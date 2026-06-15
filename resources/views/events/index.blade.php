@extends('layouts.app')

@section('title', 'Evenements - ClubPilot')

@section('content')
    <h1 class="page-title">Evenements - {{ $club->name }}</h1>

    <form method="GET" action="{{ route('clubs.events.index', $club) }}">
    <input type="text" name="search" placeholder="Rechercher titre ou lieu" value="{{ request('search') }}">

    <select name="status">
        <option value="">Tous les statuts</option>
        <option value="planned" @selected(request('status') === 'planned')>Planifié</option>
        <option value="ongoing" @selected(request('status') === 'ongoing')>En cours</option>
        <option value="finished" @selected(request('status') === 'finished')>Terminé</option>
        <option value="cancelled" @selected(request('status') === 'cancelled')>Annulé</option>
    </select>

    <button class="form-button" type="submit">Filtrer</button>
    <a class="secondary-link" href="{{ route('clubs.events.index', $club) }}">Réinitialiser</a>
</form>

    @if (request()->user()->canManageClubOperations($club))
    <p>
        <a class="action-link" href="{{ route('clubs.events.create', $club) }}">Créer un événement</a>
    </p>
@endif

    @if ($events->isEmpty())
        <p>Aucun événement pour le moment.</p>
    @else
        <ul>
            @foreach ($events as $event)
                <li>
                    <a class="secondary-link"href="{{ route('clubs.events.show', [$club, $event]) }}">
                        {{ $event->title }}
                    </a>
                    - {{ $event->start_date->format('d/m/Y H:i') }}
                    - {{ $event->status }}
                </li>
            @endforeach
        </ul>
    @endif

    <p>
        <a class="simple-link" href="{{ route('clubs.show', $club) }}">Retour au club</a>
    </p>
@endsection