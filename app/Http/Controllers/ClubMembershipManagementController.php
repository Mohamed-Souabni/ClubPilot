<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use Illuminate\Http\Request;

class ClubMembershipManagementController extends Controller
{
  public function requests(Request $request, Club $club)
{
    abort_unless($request->user()->isPresidentOf($club), 403);

    $pendingMemberships = ClubMember::with('user')
        ->where('club_id', $club->id)
        ->where('status', 'pending')
        ->latest()
        ->get();

    return view('clubs.membership-requests', compact('club', 'pendingMemberships'));
}

    public function approve(Request $request, Club $club, ClubMember $membership)
    {
        abort_unless($request->user()->isPresidentOf($club), 403);
        abort_unless($membership->club_id === $club->id, 404);

        $membership->update([
            'status' => 'active',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'joined_at' => now(),
        ]);

        return back()->with('success', 'Demande acceptée.');
    }

    public function refuse(Request $request, Club $club, ClubMember $membership)
    {
        abort_unless($request->user()->isPresidentOf($club), 403);
        abort_unless($membership->club_id === $club->id, 404);

        $membership->update([
            'status' => 'refused',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Demande refusée.');
    }

   
}