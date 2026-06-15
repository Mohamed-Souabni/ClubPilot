<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClubController extends Controller
{
    public function index(Request $request)
    {
        $clubs = $request->user()->clubs()->get();

        return view('clubs.index', compact('clubs'));
    }

    public function create()
    {
        return view('clubs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

       

        $club = DB::transaction(function () use ($request, $data) {
             $logoPath = $request->hasFile('logo')
             ? $request->file('logo')->store('clubs/logos', 'public')
              : null;

            $club = Club::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'created_by' => $request->user()->id,
                'logo' => $logoPath,
            ]);

            $club->members()->attach($request->user()->id, [
                'role' => 'president',
                'status' => 'active',
                'joined_at' => now(),
            ]);

            return $club;
        });

        return redirect()->route('clubs.show', $club)
            ->with('success', 'Club créé avec succès.');
    }

    public function show(Club $club)
    {
        $members = $club->members()->get();

        return view('clubs.show', compact('club', 'members'));
    }
    public function edit(Request $request, Club $club)
{
    abort_unless($request->user()->isPresidentOf($club), 403);

    return view('clubs.edit', compact('club'));
}

public function update(Request $request, Club $club)
{
    abort_unless($request->user()->isPresidentOf($club), 403);

    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
    ]);

    if ($request->hasFile('logo')) {
        if ($club->logo) {
            Storage::disk('public')->delete($club->logo);
        }

        $data['logo'] = $request->file('logo')->store('clubs/logos', 'public');
    }

    $club->update($data);

    return redirect()->route('clubs.show', $club)
        ->with('success', 'Club mis à jour avec succès.');
}
}
