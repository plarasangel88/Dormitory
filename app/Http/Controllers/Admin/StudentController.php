<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student')->with('room');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $students = $query->latest()->paginate(8)->withQueryString();
        $rooms    = Room::orderBy('room_number')->get();

        return view('admin.student', compact('students', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'contact_number'  => 'nullable|string|max:20',
            'room_id'         => 'nullable|exists:rooms,id',
            'status'          => 'required|in:active,inactive',
            'password'        => 'required|string|min:6',
        ]);

        if (!empty($validated['room_id'])) {
            $this->assertRoomHasSpace($validated['room_id']);
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'student';
        $validated['username'] = $this->generateUsername($validated['email']);

        User::create($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student added successfully.');
    }

    public function update(Request $request, User $student)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $student->id,
            'contact_number'  => 'nullable|string|max:20',
            'room_id'         => 'nullable|exists:rooms,id',
            'status'          => 'required|in:active,inactive',
        ]);

        // Only enforce the capacity check if the student is being
        // moved into a different room than the one they're already in.
        if (!empty($validated['room_id']) && $validated['room_id'] != $student->room_id) {
            $this->assertRoomHasSpace($validated['room_id']);
        }

        $student->update($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student)
    {
        $student->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Generate a unique username from an email address,
     * e.g. "angelplaras@gmail.com" -> "angelplaras", or
     * "angelplaras1" if that username is already taken.
     */
    private function generateUsername(string $email): string
    {
        $base = Str::slug(explode('@', $email)[0], '');
        $base = $base !== '' ? $base : 'user';

        $username = $base;
        $suffix = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . $suffix;
            $suffix++;
        }

        return $username;
    }

    /**
     * Throw a validation error (rendered wherever @error('room_id')
     * is displayed) if the room is already at full capacity.
     */
    private function assertRoomHasSpace(int $roomId): void
    {
        $room = Room::withCount('students')->findOrFail($roomId);

        if ($room->students_count >= $room->capacity) {
            throw ValidationException::withMessages([
                'room_id' => "Room {$room->room_number} is full ({$room->students_count}/{$room->capacity}). Please choose another room.",
            ]);
        }
    }
}