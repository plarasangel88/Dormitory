<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\MaintenanceRequest;
use App\Models\ActivityLog;

class Dashboard
{
    /**
     * Get all aggregated metrics for the admin dashboard.
     */
    public static function getMetrics(): array
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'Occupied')->count();
        $availableRooms = Room::where('status', 'Available')->count();
        $maintenanceRooms = Room::where('status', 'Under Maintenance')->count();

        $occupancyRate = $totalRooms > 0 
            ? round(($occupiedRooms / $totalRooms) * 100, 1) 
            : 0;

        return [
            'totalStudents'     => $totalStudents,
            'totalRooms'        => $totalRooms,
            'availableRooms'    => $availableRooms,
            'occupiedRooms'     => $occupiedRooms,
            'maintenanceRooms'  => $maintenanceRooms,
            'occupancyRate'     => $occupancyRate,
            'pendingRepairs'    => MaintenanceRequest::where('status', 'Pending')->count(),
            'monthlyBookings'   => Booking::whereMonth('created_at', now()->month)->count(),
            'totalRevenue'      => Payment::where('status', 'Paid')->sum('amount'),
            'activityFeed'      => ActivityLog::latest()->take(10)->get(),
            'recentPayments'    => Payment::with('student')->latest()->take(5)->get(),
        ];
    }
}