<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $requests = MaintenanceRequest::with(['user', 'room'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'pending'     => MaintenanceRequest::where('status', 'pending')->count(),
            'in_progress' => MaintenanceRequest::where('status', 'in_progress')->count(),
            'completed'   => MaintenanceRequest::where('status', 'completed')->count(),
            'rejected'    => MaintenanceRequest::where('status', 'rejected')->count(),
        ];

      return view('admin.maintenance', compact('requests', 'counts', 'status'));
    }

    public function show(MaintenanceRequest $maintenance)
    {
        $maintenance->load(['user', 'room', 'resolvedBy']);
        return redirect()->route('admin.maintenance.index', [
            'status' => $maintenance->status,
            'open' => $maintenance->id,
        ]);
    }

    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        $validated = $request->validate([
            'status'      => 'required|in:pending,in_progress,completed,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $maintenance->status = $validated['status'];
        $maintenance->admin_notes = $validated['admin_notes'] ?? $maintenance->admin_notes;

        if (in_array($validated['status'], ['completed', 'rejected'])) {
            $maintenance->resolved_by = Auth::id();
            $maintenance->resolved_at = now();
        } else {
            $maintenance->resolved_by = null;
            $maintenance->resolved_at = null;
        }

        $maintenance->save();

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
