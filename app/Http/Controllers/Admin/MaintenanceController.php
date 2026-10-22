<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\User;
use App\Notifications\MaintenanceActivityNotification;
use App\Notifications\SystemActivityNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('search', ''));

        $requests = MaintenanceRequest::with(['user', 'room', 'assignee', 'messages.user'])->withCount('messages')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%')
                        ->orWhereHas('user', fn ($userQuery) => $userQuery->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%'))
                        ->orWhereHas('room', fn ($roomQuery) => $roomQuery->where('room_number', 'like', '%'.$search.'%'));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'pending' => MaintenanceRequest::where('status', 'pending')->count(),
            'in_progress' => MaintenanceRequest::where('status', 'in_progress')->count(),
            'completed' => MaintenanceRequest::where('status', 'completed')->count(),
            'rejected' => MaintenanceRequest::where('status', 'rejected')->count(),
        ];

        $admins = User::query()->where('role', 'admin')->orderBy('name')->get(['id', 'name']);

        return view('admin.maintenance', compact('requests', 'counts', 'status', 'admins', 'search'));
    }

    public function show(MaintenanceRequest $maintenance)
    {
        $maintenance->load(['user', 'room', 'resolvedBy']);

        return redirect()->route('admin.maintenance.index', [
            'status' => $maintenance->status,
            'open' => $maintenance->id,
        ]);
    }

    public function update(Request $request, MaintenanceRequest $maintenance): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,rejected',
            'admin_notes' => 'nullable|string|max:1000',
            'assigned_to' => ['nullable', Rule::exists('users', 'id')->where('role', 'admin')],
            'due_at' => ['nullable', 'date'],
        ]);

        $statusChanged = $maintenance->status !== $validated['status'];
        $adminNotes = $validated['admin_notes'] ?? $maintenance->admin_notes;
        $notesChanged = $maintenance->admin_notes !== $adminNotes;
        $assignedTo = array_key_exists('assigned_to', $validated) ? $validated['assigned_to'] : $maintenance->assigned_to;
        $assignedTo = $assignedTo === null ? null : (int) $assignedTo;
        $dueAt = array_key_exists('due_at', $validated) ? $validated['due_at'] : $maintenance->due_at;
        $assignmentChanged = $maintenance->assigned_to !== $assignedTo;
        $dueDateChanged = optional($maintenance->due_at)->toDateTimeString() !== (is_string($dueAt) ? Carbon::parse($dueAt)->toDateTimeString() : optional($dueAt)->toDateTimeString());

        $maintenance->status = $validated['status'];
        $maintenance->admin_notes = $adminNotes;
        $maintenance->assigned_to = $assignedTo;
        $maintenance->due_at = $dueAt;

        if (in_array($validated['status'], ['completed', 'rejected'])) {
            if ($statusChanged || $maintenance->resolved_at === null) {
                $maintenance->resolved_by = Auth::id();
                $maintenance->resolved_at = now();
            }
        } else {
            $maintenance->resolved_by = null;
            $maintenance->resolved_at = null;
        }

        $maintenance->save();

        if ($assignmentChanged && $maintenance->assignee !== null) {
            $maintenance->assignee->notify(new SystemActivityNotification([
                'type' => 'maintenance',
                'title' => 'Maintenance request assigned',
                'message' => 'A maintenance request for Room '.($maintenance->room->room_number ?? 'N/A').' was assigned to you.',
                'url' => route('admin.maintenance.index', ['status' => $maintenance->status, 'open' => $maintenance->id]),
                'icon' => 'fa-wrench',
                'maintenance_id' => $maintenance->id,
            ]));
        }

        if ($statusChanged || $notesChanged || $assignmentChanged || $dueDateChanged) {
            $message = $statusChanged
                ? 'Your maintenance request is now '.Str::headline($maintenance->status).'.'
                : 'The administrator updated your maintenance request.';

            if ($assignmentChanged) {
                $message .= ' Assigned to '.($maintenance->assignee?->name ?? 'no administrator').'.';
            }

            if ($dueDateChanged) {
                $message .= ' Target date: '.($maintenance->due_at?->format('M d, Y g:i A') ?? 'cleared').'.';
            }

            if ($notesChanged && filled($adminNotes)) {
                $message .= ' '.Str::limit($adminNotes, 150);
            }

            $maintenance->user->notify(new MaintenanceActivityNotification(
                $maintenance->id,
                $maintenance->status,
                'Maintenance request updated',
                $message,
            ));
        }

        return redirect()
            ->route('admin.maintenance.index')
            ->with('success', 'Maintenance request updated successfully.');
    }

    public function destroy(MaintenanceRequest $maintenance)
    {
        $maintenance->delete();

        return redirect()
            ->route('admin.maintenance.index')
            ->with('success', 'Maintenance request deleted.');
    }
}
