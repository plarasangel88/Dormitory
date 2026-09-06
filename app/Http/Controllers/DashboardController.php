<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Student;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Module 3 & 8: Key Room & Occupancy Metrics
        $totalStudents = Student::where('status', 'Active')->count();
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'Available')->count();
        $occupiedRooms = Room::where('status', 'Occupied')->count();
        $maintenanceRooms = Room::where('status', 'Under Maintenance')->count();
        
        $occupancyRate = $totalRooms > 0 
            ? round(($occupiedRooms / $totalRooms) * 100, 1) 
            : 0;

        // Module 4 & 8: Fee & Payment Summary Metrics
        $monthlyBookings = Booking::whereMonth('created_at', now()->month)->count();
        $totalRevenue = Payment::where('status', 'Paid')->sum('amount');
        $pendingPaymentsCount = Payment::whereIn('status', ['Unpaid', 'Pending'])->count();
        $totalOverdueBalance = Payment::where('status', 'Unpaid')->sum('amount');

        // Module 6: Maintenance Request Metrics
        $pendingRepairs = MaintenanceRequest::where('status', 'Pending')->count();

        // Module 8.2: Real-time Activity Feed (Latest 10 actions)
        $activityFeed = ActivityLog::latest()->take(10)->get();

        // Module 8.3: Student Payment Monitoring List (Recent / Overdue)
        $recentPayments = Payment::with('student')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'occupancyRate',
            'monthlyBookings',
            'totalRevenue',
            'pendingPaymentsCount',
            'totalOverdueBalance',
            'pendingRepairs',
            'activityFeed',
            'recentPayments'
        ));
    }
}