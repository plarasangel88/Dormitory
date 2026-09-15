<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function index()
    {
        $requests = MaintenanceRequest::with('room')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('maintenance.index', compact('requests'));
    }

    public function create()
    {
        $rooms = Auth::user()->rooms ?? \App\Models\Room::all();

        return view('maintenance.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'     => 'required|exists:rooms,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'priority'    => 'required|in:low,medium,high',
        ]);

        MaintenanceRequest::create([
            'user_id'     => Auth::id(),
            'room_id'     => $validated['room_id'],
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'priority'    => $validated['priority'],
            'status'      => 'pending',
        ]);

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Maintenance request submitted successfully.');
    }

    public function show(MaintenanceRequest $maintenance)
    {
        abort_unless($maintenance->user_id === Auth::id(), 403);

        $maintenance->load('room');

        return view('maintenance.show', compact('maintenance'));
    }
}