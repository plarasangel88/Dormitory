<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $payments = Payment::with('student')
            ->when($search, function ($query, $search) {
                $query->where('reference_number', 'like', "%{$search}%")
                      ->orWhereHas('student', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->latest('payment_date')
            ->paginate(10)
            ->withQueryString();

        $students = Student::orderBy('name')->get();

        return view('admin.payment', compact('payments', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'        => ['required', 'exists:students,id'],
            'amount'            => ['required', 'numeric', 'min:0'],
            'payment_method'    => ['required', 'in:cash,gcash,bank_transfer,other'],
            'status'            => ['required', 'in:paid,pending,overdue'],
            'reference_number'  => ['nullable', 'string', 'max:50'],
            'payment_date'      => ['required', 'date'],
            'remarks'           => ['nullable', 'string'],
        ]);

        Payment::create($validated);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'student_id'        => ['required', 'exists:students,id'],
            'amount'            => ['required', 'numeric', 'min:0'],
            'payment_method'    => ['required', 'in:cash,gcash,bank_transfer,other'],
            'status'            => ['required', 'in:paid,pending,overdue'],
            'reference_number'  => ['nullable', 'string', 'max:50'],
            'payment_date'      => ['required', 'date'],
            'remarks'           => ['nullable', 'string'],
        ]);

        $payment->update($validated);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}