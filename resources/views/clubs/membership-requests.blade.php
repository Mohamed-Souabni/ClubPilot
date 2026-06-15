@extends('layouts.app')

@section('title', 'Demandes adhesion - ClubPilot')

@section('content')
    <h1 class="page-title"> Demandes adhesion - {{ $club->name }}</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($pendingMemberships->isEmpty())
        <p>Aucune demande en attente.</p>
    @else
        <ul>
            @foreach ($pendingMemberships as $membership)
                <li>
                    {{ $membership->user->name }} - {{ $membership->user->email }}

                    <form method="POST" action="{{ route('clubs.memberships.approve', [$club, $membership]) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button class="form-button" type="submit">Accepter</button>
                    </form>

                    <form method="POST" action="{{ route('clubs.memberships.refuse', [$club, $membership]) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button class="danger-button" type="submit">Refuser</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif

    <p>
        <a class="simple-link" href="{{ route('clubs.show', $club) }}">Retour au club</a>
    </p>
@endsection