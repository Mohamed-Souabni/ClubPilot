<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class MembershipRequestController extends Controller
{
    public function browse(Request $request)
    {
        $clubs = Club::withCount('activeMembers')
            ->latest()
            ->get();

        $userClubIds = $request->user()
            ->clubMemberships()
            ->pluck('club_id')
            ->toArray();

        return view('clubs.browse', compact('clubs', 'userClubIds'));
    }

    public function store(Request $request, Club $club)
    {
        $alreadyExists = $request->user()
            ->clubMemberships()
            ->where('club_id', $club->id)
            ->exists();

        if ($alreadyExists) {
            return back()->with('error', 'Vous avez déjà une relation avec ce club.');
        }

        $club->members()->attach($request->user()->id, [
            'role' => 'member',
            'status' => 'pending',
        ]);

        return back()->with('success', 'Demande d’adhésion envoyée.');
    }
}