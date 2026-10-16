<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    /**
     * Show the maintenance page: submission form + the authenticated
     * student's own request history.
     */
    public function index(): View
    {
        $userId = auth()->id();

        $requests = MaintenanceRequest::where('user_id', $userId)->with('room')
            ->latest()
            ->get();
        $selectedRequest = $requests->firstWhere('id', (int) request()->query('request'));

        $pendingCount    = $requests->where('status', 'pending')->count();
        $inProgressCount = $requests->where('status', 'in_progress')->count();
        $resolvedCount   = $requests->where('status', 'completed')->count();

        return view('student.maintenance', [
            'requests'        => $requests,
            'selectedRequest' => $selectedRequest,
            'totalCount'      => $requests->count(),
            'pendingCount'    => $pendingCount,
            'inProgressCount' => $inProgressCount,
            'resolvedCount'   => $resolvedCount,
        ]);
    }

    public function create()
    {
        return redirect()->route('maintenance.index');
    }

    public function show(MaintenanceRequest $maintenance)
    {
        abort_unless((int) $maintenance->user_id === (int) auth()->id(), 404);

        return redirect()->route('maintenance.index', ['request' => $maintenance->id]);
    }

    /**
     * Store a newly submitted maintenance request for the authenticated user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category'    => ['required', 'string', 'max:100'],
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:2000'],
            'priority'    => ['required', 'in:low,medium,high'],
        ]);

        $user = auth()->user();
        if (!$user->room_id) {
            return back()->withErrors(['room' => 'You need an assigned room before submitting a maintenance request.'])->withInput();
        }

        // The current schema has no category column, so retain the chosen category in the title.
        $validated['title'] = '[' . $validated['category'] . '] ' . $validated['title'];

        MaintenanceRequest::create([
            'user_id'     => auth()->id(),
            'title'       => $validated['title'],
            'room_id'     => $user->room_id,
            'description' => $validated['description'],
            'priority'    => $validated['priority'],
            'status'      => 'pending',
        ]);

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Your maintenance request has been submitted.');
    }
}
