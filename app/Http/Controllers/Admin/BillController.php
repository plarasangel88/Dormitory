<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Bill, Room};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'month' => ['nullable', 'date_format:Y-m'],
        ]);
        return redirect()->route('admin.payments.index', [
            'section' => 'billing',
            'month' => $filters['month'] ?? now()->format('Y-m'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'       => 'required|exists:rooms,id',
            'billing_month' => 'required|date_format:Y-m',
            'rent'          => 'required|numeric|min:0',
            'electricity'   => 'required|numeric|min:0',
            'water'         => 'required|numeric|min:0',
            'split'         => 'nullable|boolean',
            'due_date'      => 'nullable|date',
            'remarks'       => 'nullable|string|max:255',
        ]);

        $room     = Room::with('students')->findOrFail($data['room_id']);
        $students = $room->students;

        if ($students->isEmpty()) {
            return back()->withErrors('This room has no students assigned yet.')->withInput();
        }

        $month = Carbon::createFromFormat('Y-m', $data['billing_month'])->startOfMonth();
        $n     = $request->boolean('split') ? $students->count() : 1;

        foreach ($students as $student) {
            Bill::updateOrCreate(
                ['student_id' => $student->id, 'billing_month' => $month->toDateString()],
                [
                    'room_id'     => $room->id,
                    'rent'        => $data['rent'],
                    'electricity' => round($data['electricity'] / $n, 2),
                    'water'       => round($data['water'] / $n, 2),
                    'due_date'    => $data['due_date'] ?? null,
                    'remarks'     => $data['remarks'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.payments.index', ['section' => 'billing', 'month' => $month->format('Y-m')])
            ->with('success', "Bills saved for {$students->count()} student(s) in Room {$room->room_number}.");
    }

    public function update(Request $request, Bill $bill)
    {
        $data = $request->validate([
            'rent'        => 'required|numeric|min:0',
            'electricity' => 'required|numeric|min:0',
            'water'       => 'required|numeric|min:0',
            'due_date'    => 'nullable|date',
            'remarks'     => 'nullable|string|max:255',
        ]);
        $bill->update($data);

        return redirect()->route('admin.payments.index', [
            'section' => 'billing',
            'month' => $bill->billing_month->format('Y-m'),
        ])->with('success', 'Bill updated.');
    }

    public function destroy(Bill $bill)
    {
        $month = $bill->billing_month->format('Y-m');
        $bill->delete();
        return redirect()->route('admin.payments.index', [
            'section' => 'billing',
            'month' => $month,
        ])->with('success', 'Bill removed.');
    }
}
