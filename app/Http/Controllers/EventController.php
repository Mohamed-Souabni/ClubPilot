<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
   public function index(Request $request, Club $club)
{
   abort_unless($request->user()->isActiveMemberOf($club), 403);

    $events = $club->events()
        ->when($request->filled('search'), function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->filled('status'), function ($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->latest('start_date')
        ->get();

    return view('events.index', compact('club', 'events'));
}

    public function create(Request $request, Club $club)
    {
        abort_unless($request->user()->canManageClubOperations($club), 403);
        return view('events.create', compact('club'));
    }

    public function store(Request $request, Club $club)
    {
       abort_unless($request->user()->canManageClubOperations($club), 403);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:planned,ongoing,finished,cancelled'],
        ]);

        $event = $club->events()->create([
            'created_by' => $request->user()->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'location' => $data['location'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'status' => $data['status'],
            'qr_code' => Str::uuid()->toString(),
        ]);

        return redirect()->route('clubs.events.show', [$club, $event])
            ->with('success', 'Événement créé avec succès.');
    }

    public function show(Request $request, Club $club, Event $event)
    {
        abort_unless($request->user()->isActiveMemberOf($club), 403);
        abort_unless($event->club_id === $club->id, 404);

        return view('events.show', compact('club', 'event'));
    }

    
    public function edit(Request $request, Club $club, Event $event)
{
    abort_unless($event->club_id === $club->id, 404);
   abort_unless($request->user()->canManageClubOperations($club), 403);

    return view('events.edit', compact('club', 'event'));
}

public function update(Request $request, Club $club, Event $event)
{
    abort_unless($event->club_id === $club->id, 404);
    abort_unless($request->user()->canManageClubOperations($club), 403);

    $data = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'location' => ['nullable', 'string', 'max:255'],
        'start_date' => ['required', 'date'],
        'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        'status' => ['required', 'in:planned,ongoing,finished,cancelled'],
    ]);

    $event->update($data);

    return redirect()
        ->route('clubs.events.show', [$club, $event])
        ->with('success', 'Evenement mis a jour avec succes.');
}

public function destroy(Request $request, Club $club, Event $event)
{
    abort_unless($event->club_id === $club->id, 404);
    abort_unless($request->user()->canManageClubOperations($club), 403);

    $event->delete();

    return redirect()
        ->route('clubs.events.index', $club)
        ->with('success', 'Evenement supprime avec succes.');
}
}