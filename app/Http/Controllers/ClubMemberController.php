<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClubMemberController extends Controller
{
   public function index(Request $request, Club $club)
{
    abort_unless($request->user()->isPresidentOf($club), 403);

    $memberships = ClubMember::with('user')
        ->where('club_id', $club->id)
        ->whereIn('status', ['active', 'inactive'])
        ->when($request->filled('role'), function ($query) use ($request) {
            $query->where('role', $request->role);
        })
        ->when($request->filled('status'), function ($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->when($request->filled('search'), function ($query) use ($request) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        })
        ->latest()
        ->get();

    return view('clubs.members.index', compact('club', 'memberships'));
}

    public function update(Request $request, Club $club, ClubMember $membership)
    {
        abort_unless($request->user()->isPresidentOf($club), 403);
        abort_unless($membership->club_id === $club->id, 404);
        abort_unless($membership->role !== 'president', 403);

        $data = $request->validate([
            'role' => ['required', Rule::in(['admin', 'member'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $membership->update($data);

        return back()->with('success', 'Membre mis a jour avec succes.');
    }

    public function destroy(Request $request, Club $club, ClubMember $membership)
    {
        abort_unless($request->user()->isPresidentOf($club), 403);
        abort_unless($membership->club_id === $club->id, 404);
        abort_unless($membership->role !== 'president', 403);

        $membership->delete();

        return back()->with('success', 'Membre retire du club.');
    }

    
}