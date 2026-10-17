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
        $roomCapacity = Room::withCount('students')->get(['id', 'capacity']);
        $totalRooms = $roomCapacity->count();
        $totalBeds = (int) $roomCapacity->sum('capacity');
        $occupiedBeds = (int) $roomCapacity->sum('students_count');
        $vacantBeds = max(0, $totalBeds - $occupiedBeds);
        $pendingPayments = Payment::where('status', 'pending')->count();
        $totalCollected = Payment::where('status', 'verified')->sum('amount');

        $occupancyRate = $totalBeds > 0
            ? round(($occupiedBeds / $totalBeds) * 100, 1)
            : 0;

        $announcements = Announcement::with('author')->feed()->take(10)->get();
        $paymentMonitoring = Payment::with(['user.room'])
            ->latest()
            ->take(30)
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
            'totalBeds',
            'occupiedBeds',
            'vacantBeds',
            'pendingPayments',
            'totalCollected',
            'occupancyRate',
            'announcements',
            'paymentMonitoring'
        ));
    }
}
