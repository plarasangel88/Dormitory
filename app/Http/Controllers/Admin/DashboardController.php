<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registry;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Registry::where('role', 'student')->count();

        $availableRooms = 0;
        $totalRooms = 0;
        $occupiedRooms = 0;
        $maintenanceRooms = 0;
        $occupancyRate = 0;
        $pendingRepairs = 0;
        $activityFeed = collect();
        $recentPayments = collect();

        return view('admin.dashboard', compact(
            'totalStudents', 'availableRooms', 'totalRooms',
            'occupiedRooms', 'maintenanceRooms', 'occupancyRate',
            'pendingRepairs', 'activityFeed', 'recentPayments'
        ));
    }
}