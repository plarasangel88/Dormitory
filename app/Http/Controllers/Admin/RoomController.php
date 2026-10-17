<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function show(Room $room)
    {
        $room->load(['students:id,room_id,name,email,course,contact_number,emergency_contact_number,residency_place,status']);

        return view('admin.room-show', compact('room'));
    }

    public function index(Request $request)
    {
        $roomCapacity = Room::query()->withCount('students')->get(['id', 'capacity']);
        $totalRooms = $roomCapacity->count();
        $totalBeds = (int) $roomCapacity->sum('capacity');
        $occupiedBeds = (int) $roomCapacity->sum('students_count');
        $vacantBeds = max(0, $totalBeds - $occupiedBeds);
        $occupancyRate = $totalBeds > 0 ? round(($occupiedBeds / $totalBeds) * 100, 1) : 0;

        $query = Room::query()->withCount('students');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('room_number', 'like', "%{$search}%");
        }

        $rooms = $query->latest()->paginate(8)->withQueryString();

        return view('admin.room', compact(
            'rooms',
            'totalRooms',
            'totalBeds',
            'occupiedBeds',
            'vacantBeds',
            'occupancyRate'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:20|unique:rooms,room_number',
            'capacity'    => 'required|integer|min:1',
            'status'      => 'required|in:available,occupied,maintenance',
        ]);

        Room::create($validated);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room added successfully.');
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:20|unique:rooms,room_number,' . $room->id,
            'capacity'    => 'required|integer|min:1',
            'status'      => 'required|in:available,occupied,maintenance',
        ]);

        $room->update($validated);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        if ($room->students()->exists()) {
            return redirect()
                ->route('admin.rooms.index')
                ->with('error', 'Cannot delete a room that still has students assigned.');
        }

        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}
