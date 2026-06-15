@extends('layouts.app')

@section('title', 'Tâches - ClubPilot')


@section('content')
    <h1 class="page-title">Tâches - {{ $club->name }}</h1>

    <form method="GET" action="{{ route('clubs.tasks.index', $club) }}">
    <input type="text" name="search" placeholder="Rechercher une tâche" value="{{ request('search') }}">

    <select name="status">
        <option value="">Tous les statuts</option>
        <option value="todo" @selected(request('status') === 'todo')>À faire</option>
        <option value="in_progress" @selected(request('status') === 'in_progress')>En cours</option>
        <option value="done" @selected(request('status') === 'done')>Terminée</option>
    </select>

    <select name="priority">
        <option value="">Toutes les priorités</option>
        <option value="low" @selected(request('priority') === 'low')>Basse</option>
        <option value="medium" @selected(request('priority') === 'medium')>Moyenne</option>
        <option value="high" @selected(request('priority') === 'high')>Haute</option>
    </select>

    <select name="assigned_to">
        <option value="">Toutes les assignations</option>
        <option value="me" @selected(request('assigned_to') === 'me')>Mes tâches</option>
        <option value="none" @selected(request('assigned_to') === 'none')>Non assignées</option>
    </select>

    <button class="form-button" type="submit">Filtrer</button>
    <a class="secondary-link" href="{{ route('clubs.tasks.index', $club) }}">Réinitialiser</a>
</form>

 @if (request()->user()->canManageClubOperations($club))
    <p>
        <a class="action-link" href="{{ route('clubs.tasks.create', $club) }}">Créer une tâche</a>
    </p>
@endif

    @if ($tasks->isEmpty())
        <p>Aucune tâche pour le moment.</p>
    @else
        <ul>
            @foreach ($tasks as $task)
                <li>
                    <a class="secondary-link" href="{{ route('clubs.tasks.show', [$club, $task]) }}">
                        {{ $task->title }}
                    </a>
                    - statut : {{ $task->status }}
                    - priorité : {{ $task->priority }}
                    - assignée à : {{ $task->assignee?->name ?? 'Non assignée' }}
                </li>
            @endforeach
        </ul>
    @endif

    <p>
        <a class="simple-link" href="{{ route('clubs.show', $club) }}">Retour au club</a>
    </p>
@endsection