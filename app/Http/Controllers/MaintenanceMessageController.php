<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\User;
use App\Notifications\MaintenanceActivityNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class MaintenanceMessageController extends Controller
{
    public function store(Request $request, MaintenanceRequest $maintenance): RedirectResponse
    {
        $user = $request->user();
        abort_unless(
            $user->role === 'admin'
                || ($user->role === 'student' && (int) $maintenance->user_id === (int) $user->id),
            403
        );

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $maintenance->messages()->create([
            'user_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $notification = new MaintenanceActivityNotification(
            $maintenance->id,
            $maintenance->status,
            'New maintenance message',
            $user->name.': '.Str::limit($validated['body'], 130),
        );

        if ($user->role === 'admin') {
            $maintenance->user->notify($notification);

            return redirect()
                ->route('admin.maintenance.index', [
                    'status' => $maintenance->status,
                    'open' => $maintenance->id,
                ])
                ->with('success', 'Your message was sent to the student.');
        }

        Notification::send(User::query()->where('role', 'admin')->get(), $notification);

        return redirect()
            ->route('maintenance.index', ['request' => $maintenance->id])
            ->with('success', 'Your message was sent to the dorm administrator.');
    }
}
