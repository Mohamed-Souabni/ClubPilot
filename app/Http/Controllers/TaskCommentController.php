<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    public function store(Request $request, Club $club, Task $task)
    {
        abort_unless($task->club_id === $club->id, 404);
        abort_unless($request->user()->isActiveMemberOf($club), 403);

        $data = $request->validate([
            'comment' => ['required', 'string', 'max:2000'],
        ]);

        $task->comments()->create([
            'user_id' => $request->user()->id,
            'comment' => $data['comment'],
        ]);

        return redirect()
            ->route('clubs.tasks.show', [$club, $task])
            ->with('success', 'Commentaire ajoute avec succes.');
    }

    
}