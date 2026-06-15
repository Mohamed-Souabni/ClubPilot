<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubDashboardController extends Controller
{
   public function show(Request $request, Club $club)
{
    abort_unless($request->user()->isActiveMemberOf($club), 403);

    $activeMembersCount = $club->activeMembers()->count();

    $upcomingEvents = $club->events()
        ->where('start_date', '>=', now())
        ->where('status', 'planned')
        ->orderBy('start_date')
        ->limit(5)
        ->get();

    $nextEvent = $club->events()
        ->where('start_date', '>=', now())
        ->where('start_date', '<=', now()->addDays(7))
        ->where('status', 'planned')
        ->orderBy('start_date')
        ->first();

    $lateTasks = $club->tasks()
        ->with('assignee')
        ->where('status', '!=', 'done')
        ->whereNotNull('due_date')
        ->whereDate('due_date', '<', today())
        ->orderBy('due_date')
        ->get();

    $lateTasksCount = $lateTasks->count();

    $myTasks = $club->tasks()
        ->where('assigned_to', $request->user()->id)
        ->where('status', '!=', 'done')
        ->orderBy('due_date')
        ->limit(5)
        ->get();

    $mySoonTasks = $club->tasks()
        ->where('assigned_to', $request->user()->id)
        ->where('status', '!=', 'done')
        ->whereNotNull('due_date')
        ->whereDate('due_date', '>=', today())
        ->whereDate('due_date', '<=', today()->addDays(3))
        ->orderBy('due_date')
        ->get();

    $balance = null;
    $budgetIsLow = false;

    if ($request->user()->isPresidentOf($club)) {
        $totalIncome = $club->budgetTransactions()
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = $club->budgetTransactions()
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;
        $budgetIsLow = $balance < 500;
    }

    return view('clubs.dashboard', compact(
        'club',
        'activeMembersCount',
        'upcomingEvents',
        'nextEvent',
        'lateTasks',
        'lateTasksCount',
        'myTasks',
        'mySoonTasks',
        'balance',
        'budgetIsLow'
    ));
}
}