<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\PaymentAudit;
use App\Models\PaymentSetting;
use App\Models\Room;
use App\Models\User;
use App\Notifications\SystemActivityNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'section' => ['nullable', 'in:payments,billing'],
            'month' => ['nullable', 'date_format:Y-m'],
        ]);
        $section = $filters['section'] ?? 'payments';
        $month = Carbon::createFromFormat('Y-m', $filters['month'] ?? now()->format('Y-m'))->startOfMonth();

        $search = $request->input('search');

        $payments = Payment::with(['user', 'bill'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('reference_number', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $students = User::where('role', 'student')->orderBy('name')->get();
        $bills = collect();
        $rooms = collect();

        if ($section === 'billing') {
            $bills = Bill::with(['student', 'room', 'payments'])
                ->whereDate('billing_month', $month)
                ->orderBy('room_id')
                ->get();

            $rooms = Room::withCount('students')->orderBy('room_number')->get();
        }

        $gcashQrPath = PaymentSetting::query()->value('gcash_qr_path');
        $gcashQrUrl = $gcashQrPath ? route('payments.gcash-qr') : null;

        return view('admin.payment', compact('payments', 'students', 'section', 'month', 'bills', 'rooms', 'gcashQrUrl'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules($request));

        $payment = DB::transaction(function () use ($validated): Payment {
            $payment = Payment::create($validated);
            $this->recordAudit($payment, 'recorded', null, $payment->status);

            return $payment;
        });

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate($this->rules($request));

        if ($payment->bill_id && (int) $payment->bill->student_id !== (int) $validated['user_id']) {
            return back()->withErrors([
                'user_id' => 'This payment is linked to a bill for a different student.',
            ])->withInput();
        }

        $previousStatus = $payment->status;
        DB::transaction(function () use ($payment, $validated, $previousStatus): void {
            $payment->update($validated);
            $this->recordAudit($payment, 'updated', $previousStatus, $payment->status);
        });
        if ($previousStatus !== $payment->status) {
            $payment->user->notify(new SystemActivityNotification([
                'type' => 'payment',
                'title' => 'Payment status updated',
                'message' => 'An administrator changed your payment status to '.str_replace('_', ' ', $payment->status).'.',
                'url' => route('payments'),
                'icon' => 'fa-wallet',
                'reference_number' => (string) $payment->reference_number,
            ]));
        }

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function verify(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return redirect()
                ->route('admin.payments.index')
                ->with('success', 'This payment has already been reviewed.');
        }

        DB::transaction(function () use ($payment): void {
            $pendingPayments = Payment::where('status', 'pending');

            // A missing reference is not a transaction identifier. Verify only
            // this legacy record instead of every unreferenced payment for the user.
            if ($payment->reference_number) {
                $pendingPayments->where('reference_number', $payment->reference_number)
                    ->where('user_id', $payment->user_id);
            } else {
                $pendingPayments->whereKey($payment->id);
            }

            $records = $pendingPayments->lockForUpdate()->get();
            foreach ($records as $record) {
                $record->update(['status' => 'verified', 'payment_date' => now()->toDateString()]);
                $this->recordAudit($record, 'verified', 'pending', 'verified');
            }
        });

        $payment->user->notify(new SystemActivityNotification([
            'type' => 'payment',
            'title' => 'Payment verified',
            'message' => 'Your payment '.($payment->reference_number ?: '#'.$payment->id).' has been verified.',
            'url' => route('payments'),
            'icon' => 'fa-circle-check',
            'reference_number' => (string) $payment->reference_number,
        ]));

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment verified and marked as received.');
    }

    public function updateGcashQr(Request $request)
    {
        $validated = $request->validate([
            'gcash_qr' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ]);

        $setting = PaymentSetting::firstOrCreate([]);
        if ($setting->gcash_qr_path) {
            Storage::disk('public')->delete($setting->gcash_qr_path);
        }
        $setting->update(['gcash_qr_path' => $validated['gcash_qr']->store('payment/qr', 'public')]);

        return redirect()->route('admin.payments.index', ['section' => 'payments'])
            ->with('success', 'GCash QR code updated.');
    }

    public function destroy(Payment $payment)
    {
        if ($payment->status === 'verified') {
            return redirect()
                ->route('admin.payments.index')
                ->withErrors(['payment' => 'Verified payment records cannot be deleted. Update the record with a correction instead.']);
        }

        DB::transaction(function () use ($payment): void {
            $this->recordAudit($payment, 'deleted', $payment->status, null);
            $payment->delete();
        });

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    private function rules(Request $request): array
    {
        return [
            'user_id' => ['required', Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'student'))],
            'bill_id' => ['sometimes', 'nullable', Rule::exists('bills', 'id')->where(fn ($query) => $query->where('student_id', $request->input('user_id')))],
            'applies_to' => ['sometimes', 'nullable', 'required_with:bill_id', 'in:rent,electricity,water'],
            'amount' => ['required', 'numeric', 'gt:0', 'max:99999999.99'],
            'method' => ['required', 'in:GCash,Cash'],
            'status' => ['required', 'in:pending,verified,rejected'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    private function recordAudit(Payment $payment, string $action, ?string $previousStatus, ?string $newStatus): void
    {
        PaymentAudit::create([
            'payment_id' => $payment->id,
            'actor_id' => auth()->id(),
            'student_id' => $payment->user_id,
            'reference_number' => $payment->reference_number,
            'action' => $action,
            'previous_status' => $previousStatus,
            'new_status' => $newStatus,
            'amount' => $payment->amount,
            'details' => ['method' => $payment->method, 'bill_id' => $payment->bill_id, 'applies_to' => $payment->applies_to],
        ]);
    }
}
