<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $totalCollected = Payment::where('status', 'verified')->sum('amount');

        $occupancyRate = $totalRooms > 0
            ? round(($occupiedRooms / $totalRooms) * 100, 1)
            : 0;

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalRooms',
            'occupiedRooms',
            'pendingPayments',
            'totalCollected',
            'occupancyRate'
        ));
    }
}