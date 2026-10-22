<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::with('author')
            ->feed()
            ->paginate(10)
            ->withQueryString();
        $totalAnnouncements = $announcements->total();
        $pinnedAnnouncements = Announcement::where('is_pinned', true)->count();

        return view('admin.announcements', compact('announcements', 'totalAnnouncements', 'pinnedAnnouncements'));
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'body' => ['required', 'string', 'max:2000'],
            'is_pinned' => ['nullable'],
        ]);

        $announcement = Announcement::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'body' => $validated['body'],
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Announcement posted successfully.'], 201);
        }

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement posted successfully!');
    }

    public function destroy(Request $request, Announcement $announcement): JsonResponse|RedirectResponse
    {
        $announcement->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Announcement deleted successfully.']);
        }

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }
}
