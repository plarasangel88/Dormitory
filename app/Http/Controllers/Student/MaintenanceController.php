<?php

namespace App\Http\Controllers;

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

        $requests = MaintenanceRequest::forUser($userId)
            ->latest()
            ->get();

        $pendingCount    = MaintenanceRequest::forUser($userId)->status('pending')->count();
        $inProgressCount = MaintenanceRequest::forUser($userId)->status('in_progress')->count();
        $resolvedCount   = MaintenanceRequest::forUser($userId)->status('resolved')->count();

        return view('maintenance', [
            'requests'        => $requests,
            'totalCount'      => $requests->count(),
            'pendingCount'    => $pendingCount,
            'inProgressCount' => $inProgressCount,
            'resolvedCount'   => $resolvedCount,
        ]);
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

        MaintenanceRequest::create([
            'user_id'     => auth()->id(),
            'category'    => $validated['category'],
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'priority'    => $validated['priority'],
            'status'      => 'pending',
        ]);

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Your maintenance request has been submitted.');
    }
}