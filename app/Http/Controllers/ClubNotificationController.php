<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClubNotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->clubNotifications()
            ->with('club')
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function create(Request $request, Club $club)
    {
        abort_unless($request->user()->canManageClubOperations($club), 403);

        return view('notifications.create', compact('club'));
    }

    public function store(Request $request, Club $club)
    {
        abort_unless($request->user()->canManageClubOperations($club), 403);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $members = $club->activeMembers()->get();
        $batchId = (string) Str::uuid();

        foreach ($members as $member) {
            ClubNotification::create([
                'batch_id' => $batchId,
                'user_id' => $member->id,
                'club_id' => $club->id,
                'created_by' => $request->user()->id,
                'title' => $data['title'],
                'message' => $data['message'],
                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Notification envoyee aux membres actifs du club.');
    }

    public function markAsRead(Request $request, ClubNotification $notification)
    {
        abort_unless($notification->user_id === $request->user()->id, 403);

        if (! $notification->is_read) {
            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return back()->with('success', 'Notification marquee comme lue.');
    }

    public function sent(Request $request, Club $club)
    {
        abort_unless($request->user()->canManageClubOperations($club), 403);

        $sentMessages = ClubNotification::query()
            ->with('creator')
            ->where('club_id', $club->id)
            ->whereNotNull('batch_id')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('batch_id')
            ->map(function ($notifications) {
                $first = $notifications->first();

                return [
                    'batch_id' => $first->batch_id,
                    'title' => $first->title,
                    'message' => $first->message,
                    'created_at' => $first->created_at,
                    'creator' => $first->creator,
                    'total_count' => $notifications->count(),
                    'read_count' => $notifications->where('is_read', true)->count(),
                    'unread_count' => $notifications->where('is_read', false)->count(),
                ];
            })
            ->values();

        return view('notifications.sent', compact('club', 'sentMessages'));
    }

    public function readers(Request $request, Club $club, string $batchId)
    {
        abort_unless($request->user()->canManageClubOperations($club), 403);

        $notifications = ClubNotification::query()
            ->with('user')
            ->where('club_id', $club->id)
            ->where('batch_id', $batchId)
            ->orderByDesc('is_read')
            ->orderBy('created_at')
            ->get();

        abort_if($notifications->isEmpty(), 404);

        $message = $notifications->first();

        return view('notifications.readers', compact('club', 'message', 'notifications'));
    }
}
