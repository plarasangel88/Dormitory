<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\PaymentSetting;
use App\Models\Room;
use App\Models\User;
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

        Payment::create($validated);

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

        $payment->update($validated);

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

        DB::transaction(function () use ($payment) {
            Payment::where('reference_number', $payment->reference_number)
                ->where('user_id', $payment->user_id)
                ->where('status', 'pending')
                ->update(['status' => 'verified', 'payment_date' => now()->toDateString()]);
        });

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
        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    private function rules(Request $request): array
    {
        return [
            'user_id'          => ['required', 'exists:users,id'],
            'bill_id'          => ['sometimes', 'nullable', Rule::exists('bills', 'id')->where(fn ($query) => $query->where('student_id', $request->input('user_id')))],
            'applies_to'       => ['sometimes', 'nullable', 'required_with:bill_id', 'in:rent,electricity,water'],
            'amount'           => ['required', 'numeric', 'min:0'],
            'method'           => ['required', 'in:GCash,Cash'],
            'status'           => ['required', 'in:pending,verified,rejected'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ];
    }
};
