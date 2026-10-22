<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\PaymentAudit;
use App\Models\PaymentSetting;
use App\Models\User;
use App\Notifications\SystemActivityNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $payments = $user->payments;
        $bills = $user->bills()->with('payments')->orderByDesc('billing_month')->get();
        $paymentReminders = $bills->filter(fn (Bill $bill): bool => $bill->due_date !== null
            && $bill->due_date->lte(now()->addDays(7)->endOfDay())
            && $bill->reminderBalance() > 0
        );
        $payableTotal = $bills->sum(function (Bill $bill) {
            return collect(Bill::ITEMS)->sum(function ($item) use ($bill) {
                $pending = $bill->payments
                    ->where('applies_to', $item)
                    ->where('status', 'pending')
                    ->sum('amount');

                return max(0, $bill->balanceFor($item) - $pending);
            });
        });

        $monthlyRate = $user->room->monthly_rate ?? 0;
        $totalPaid = $payments->where('status', 'verified')->sum('amount');
        $pendingCount = $payments->where('status', 'pending')->count();
        $transactions = $payments->groupBy(fn (Payment $payment) => $payment->reference_number ?: 'legacy-'.$payment->id)
            ->map(function ($items) {
                $transaction = $items->first();
                $transaction->transaction_total = $items->sum('amount');
                $transaction->transaction_status = $items->contains(fn ($payment) => $payment->status !== 'verified')
                    ? ($items->contains(fn ($payment) => $payment->status === 'pending') ? 'pending' : 'rejected')
                    : 'verified';

                return $transaction;
            })->values();
        $gcashQrUrl = PaymentSetting::query()->value('gcash_qr_path')
            ? route('payments.gcash-qr')
            : null;

        return view('student.payments', compact('payments', 'transactions', 'bills', 'paymentReminders', 'payableTotal', 'monthlyRate', 'totalPaid', 'pendingCount', 'gcashQrUrl'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'method' => 'required|string|in:GCash,Cash',
            'notes' => 'nullable|string|max:500',
        ]);

        $transactionReference = 'DORM-'.now()->format('Ymd').'-'.Str::upper(Str::random(8));

        $user = Auth::user();

        DB::transaction(function () use ($user, $validated, $transactionReference) {
            // Lock the student's bill rows so two submissions cannot allocate the
            // same outstanding balance at the same time.
            $bills = $user->bills()
                ->with('payments')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            $allocations = [];
            foreach ($bills as $bill) {
                foreach (Bill::ITEMS as $item) {
                    $pending = $bill->payments
                        ->where('applies_to', $item)
                        ->where('status', 'pending')
                        ->sum('amount');
                    $available = max(0, $bill->balanceFor($item) - $pending);

                    if ($available > 0) {
                        $allocations[] = [
                            'bill_id' => $bill->id,
                            'applies_to' => $item,
                            'amount' => round($available, 2),
                        ];
                    }
                }
            }

            if ($allocations === []) {
                throw ValidationException::withMessages([
                    'payment' => 'There are no unpaid dues available to submit. Any pending payments must be verified first.',
                ]);
            }

            foreach ($allocations as $allocation) {
                $payment = $user->payments()->create($allocation + [
                    'method' => $validated['method'],
                    'reference_number' => $transactionReference,
                    'status' => 'pending',
                    'notes' => $validated['notes'] ?? null,
                ]);

                PaymentAudit::create([
                    'payment_id' => $payment->id,
                    'actor_id' => $user->id,
                    'student_id' => $user->id,
                    'reference_number' => $transactionReference,
                    'action' => 'submitted',
                    'new_status' => 'pending',
                    'amount' => $payment->amount,
                    'details' => ['method' => $payment->method, 'bill_id' => $payment->bill_id, 'applies_to' => $payment->applies_to],
                ]);
            }
        });

        $admins = User::query()->where('role', 'admin')->get();
        Notification::send($admins, new SystemActivityNotification([
            'type' => 'payment',
            'title' => 'Payment submitted',
            'message' => $user->name.' submitted payment '.$transactionReference.' for review.',
            'url' => route('admin.payments.index'),
            'icon' => 'fa-wallet',
            'reference_number' => $transactionReference,
        ]));

        return back()->with('success', 'Your full available balance was submitted. Transaction reference: '.$transactionReference.'. It is pending verification.');
    }

    public function receipt(string $reference)
    {
        $payments = Auth::user()->payments()
            ->with('bill')
            ->where('reference_number', $reference)
            ->orderBy('id')
            ->get();

        abort_if($payments->isEmpty() || $payments->contains(fn (Payment $payment) => $payment->status !== 'verified'), 404);

        return view('student.payment-receipt', [
            'payments' => $payments,
            'transaction' => $payments->first(),
            'total' => $payments->sum('amount'),
        ]);
    }

    public function gcashQr()
    {
        $path = PaymentSetting::query()->value('gcash_qr_path');
        abort_unless($path && Storage::disk('public')->exists($path), 404);

        return Storage::disk('public')->response($path);
    }
}
