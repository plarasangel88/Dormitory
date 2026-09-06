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

        $monthlyRate = $user->room->monthly_rate ?? 0;
        $totalPaid = $payments->where('status', 'verified')->sum('amount');
        $pendingCount = $payments->where('status', 'pending')->count();

        return view('student.payments', compact('payments', 'monthlyRate', 'totalPaid', 'pendingCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount'           => 'required|numeric|min:1',
            'method'           => 'required|string|in:GCash,Bank Transfer,Cash',
            'reference_number' => 'required|string|max:255',
            'notes'            => 'nullable|string|max:500',
        ]);

        Auth::user()->payments()->create([
            'amount'           => $request->amount,
            'method'           => $request->method,
            'reference_number' => $request->reference_number,
            'status'           => 'pending',
            'notes'            => $request->notes,
        ]);

        return back()->with('success', 'Payment submitted successfully! It is now pending verification.');
    }
}