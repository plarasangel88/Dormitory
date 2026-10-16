<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'is_pinned' => ['nullable'],
        ]);

        Announcement::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'body' => $validated['body'],
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Announcement posted successfully!');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Announcement deleted successfully!');
    }
}
