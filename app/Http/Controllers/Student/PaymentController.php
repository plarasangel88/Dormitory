<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $payments = $user->payments;
        $bills = $user->bills()->with('payments')->orderByDesc('billing_month')->get();
        $billItems = \App\Models\Bill::ITEMS;

        $monthlyRate = $user->room->monthly_rate ?? 0;
        $totalPaid = $payments->where('status', 'verified')->sum('amount');
        $pendingCount = $payments->where('status', 'pending')->count();

        return view('student.payments', compact('payments', 'bills', 'billItems', 'monthlyRate', 'totalPaid', 'pendingCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount'           => 'required|numeric|min:1',
            'method'           => 'required|string|in:GCash,Bank Transfer,Cash',
            'reference_number' => 'required|string|max:255',
            'notes'            => 'nullable|string|max:500',
            'bill_id'          => 'nullable|integer|exists:bills,id',
            'applies_to'       => 'required_with:bill_id|nullable|in:rent,electricity,water',
        ]);

        $billId = $validated['bill_id'] ?? null;
        if ($billId) {
            $bill = Auth::user()->bills()->with('payments')->findOrFail($billId);
            $item = $validated['applies_to'];
            $pending = $bill->payments
                ->where('applies_to', $item)
                ->where('status', 'pending')
                ->sum('amount');
            $available = max(0, $bill->balanceFor($item) - $pending);

            if ((float) $validated['amount'] > $available) {
                return back()->withErrors([
                    'amount' => 'The payment amount exceeds the remaining balance for this bill item.',
                ])->withInput();
            }
        }

        Auth::user()->payments()->create([
            'bill_id'          => $billId,
            'applies_to'       => $validated['applies_to'] ?? 'rent',
            'amount'           => $validated['amount'],
            'method'           => $validated['method'],
            'reference_number' => $validated['reference_number'],
            'status'           => 'pending',
            'notes'            => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'Payment submitted successfully! It is now pending verification.');
    }
}
