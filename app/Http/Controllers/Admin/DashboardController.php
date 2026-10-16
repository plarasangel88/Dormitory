<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Payment;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalRooms = Room::count();

        // A room counts as occupied if it has at least one student
        // assigned to it (via users.room_id), regardless of the
        // room's `status` column, since that column isn't kept in
        // sync with assignments anywhere else in the app yet.
        $occupiedRooms = Room::has('students')->count();

        $pendingPayments = Payment::where('status', 'pending')->count();
        $totalCollected = Payment::where('status', 'verified')->sum('amount');

        $occupancyRate = $totalRooms > 0
            ? round(($occupiedRooms / $totalRooms) * 100, 1)
            : 0;

        $announcements = Announcement::with('author')->feed()->take(10)->get();
        $paymentMonitoring = Payment::with(['user.room'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function (Payment $payment) {
                $payment->student_name = $payment->user?->name ?? 'Unknown student';
                $payment->room_number = $payment->user?->room?->room_number;
                $payment->amount_due = $payment->amount;
                $payment->status = match ($payment->status) {
                    'verified' => 'paid',
                    'rejected' => 'unpaid',
                    default => $payment->status,
                };

                return $payment;
            });

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalRooms',
            'occupiedRooms',
            'pendingPayments',
            'totalCollected',
            'occupancyRate',
            'announcements',
            'paymentMonitoring'
        ));
    }
}
