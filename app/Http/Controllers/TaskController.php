<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
   public function index(Request $request, Club $club)
{
    abort_unless($request->user()->isActiveMemberOf($club), 403);

    $tasks = $club->tasks()
        ->with('assignee')
        ->when($request->filled('search'), function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->search . '%');
        })
        ->when($request->filled('status'), function ($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->when($request->filled('priority'), function ($query) use ($request) {
            $query->where('priority', $request->priority);
        })
        ->when($request->filled('assigned_to'), function ($query) use ($request) {
            if ($request->assigned_to === 'me') {
                $query->where('assigned_to', $request->user()->id);
            } elseif ($request->assigned_to === 'none') {
                $query->whereNull('assigned_to');
            }
        })
        ->latest()
        ->get();

    return view('tasks.index', compact('club', 'tasks'));
}


    public function create(Request $request, Club $club)
    {
        abort_unless($request->user()->canManageClubOperations($club), 403);

        $members = $club->activeMembers()
            ->orderBy('name')
            ->get();

        return view('tasks.create', compact('club', 'members'));
    }

    public function store(Request $request, Club $club)
    {
        abort_unless($request->user()->canManageClubOperations($club), 403);

        $data = $request->validate([
            'assigned_to' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:todo,in_progress,done'],
            'priority' => ['required', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
        ]);

        if (! empty($data['assigned_to'])) {
            $isClubMember = $club->activeMembers()
                ->where('users.id', $data['assigned_to'])
                ->exists();

            abort_unless($isClubMember, 422, 'La tâche doit être assignée à un membre actif du club.');
        }

        $task = $club->tasks()->create([
            'assigned_to' => $data['assigned_to'] ?? null,
            'created_by' => $request->user()->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
            'priority' => $data['priority'],
            'due_date' => $data['due_date'] ?? null,
        ]);

        return redirect()->route('clubs.tasks.show', [$club, $task])
            ->with('success', 'Tâche créée avec succès.');
    }

    public function show(Request $request, Club $club, Task $task)
    {
        abort_unless($request->user()->isActiveMemberOf($club), 403);
        abort_unless($task->club_id === $club->id, 404);

        $task->load(['assignee', 'creator', 'comments.user']);
        return view('tasks.show', compact('club', 'task'));
    }

  
    public function edit(Request $request, Club $club, Task $task)
{
    abort_unless($task->club_id === $club->id, 404);
    abort_unless($request->user()->canManageClubOperations($club), 403);

    $members = $club->activeMembers()
        ->orderBy('name')
        ->get();

    return view('tasks.edit', compact('club', 'task', 'members'));
}

public function update(Request $request, Club $club, Task $task)
{
    abort_unless($task->club_id === $club->id, 404);
    abort_unless($request->user()->canManageClubOperations($club), 403);

    $data = $request->validate([
        'assigned_to' => ['nullable', 'exists:users,id'],
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'status' => ['required', 'in:todo,in_progress,done'],
        'priority' => ['required', 'in:low,medium,high'],
        'due_date' => ['nullable', 'date'],
    ]);

    if (! empty($data['assigned_to'])) {
        $isClubMember = $club->activeMembers()
            ->where('users.id', $data['assigned_to'])
            ->exists();

        abort_unless($isClubMember, 422, 'La tâche doit être assignée à un membre actif du club.');
    }

    $task->update([
        'assigned_to' => $data['assigned_to'] ?? null,
        'title' => $data['title'],
        'description' => $data['description'] ?? null,
        'status' => $data['status'],
        'priority' => $data['priority'],
        'due_date' => $data['due_date'] ?? null,
    ]);

    return redirect()
        ->route('clubs.tasks.show', [$club, $task])
        ->with('success', 'Tache mise a jour avec succes.');
}

public function destroy(Request $request, Club $club, Task $task)
{
    abort_unless($task->club_id === $club->id, 404);
    abort_unless($request->user()->canManageClubOperations($club), 403);

    $task->delete();

    return redirect()
        ->route('clubs.tasks.index', $club)
        ->with('success', 'Tache supprimee avec succes.');
}

}