<?php

namespace App\Http\Controllers;

use App\Models\RoomTask;
use App\Models\User;
use Illuminate\Http\Request;

class RoomTaskController extends Controller
{
    /** Assign a task to yourself or any roommate in your room. */
    public function store(Request $request)
    {
        $user = $request->user();
        abort_unless($user->room_id, 403);

        $data = $request->validate([
            'assigned_to' => ['required', 'integer'],
            'title'       => ['required', 'string', 'max:120'],
            'task_date'   => ['required', 'date', 'after_or_equal:today'],
        ]);

        // The assignee must be in the SAME room as the logged-in student
        // (this is the room the admin assigned them to).
        $sameRoom = User::where('id', $data['assigned_to'])
            ->where('room_id', $user->room_id)
            ->exists();
        abort_unless($sameRoom, 403);

        RoomTask::create([
            'room_id'     => $user->room_id,
            'assigned_to' => $data['assigned_to'],
            'assigned_by' => $user->id,
            'title'       => $data['title'],
            'task_date'   => $data['task_date'],
        ]);

        return back()->with('success', 'Task assigned.');
    }

    /** Tick / untick a task. Only the assignee or the person who assigned it. */
    public function toggle(Request $request, RoomTask $task)
    {
        $user = $request->user();
        abort_unless($task->room_id === $user->room_id, 403);
        abort_unless(in_array($user->id, [$task->assigned_to, $task->assigned_by]), 403);

        $done = ! $task->is_done;
        $task->update([
            'is_done'      => $done,
            'completed_at' => $done ? now() : null,
        ]);

        return back();
    }

    /** Delete a task. Only the person who assigned it. */
    public function destroy(Request $request, RoomTask $task)
    {
        $user = $request->user();
        abort_unless($task->room_id === $user->room_id, 403);
        abort_unless($task->assigned_by === $user->id, 403);

        $task->delete();

        return back()->with('success', 'Task removed.');
    }
}