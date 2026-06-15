@extends('layouts.app')

@section('title', $task->title . ' - ClubPilot')

@section('content')
    <h1 class="page-title">{{ $task->title }}</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <p>Club : {{ $club->name }}</p>
    <p>Description : {{ $task->description }}</p>
    <p>Statut : {{ $task->status }}</p>
    <p>Priorité : {{ $task->priority }}</p>
    <p>Assignée à : {{ $task->assignee?->name ?? 'Non assignée' }}</p>
    <p>Créée par : {{ $task->creator?->name ?? 'Inconnu' }}</p>

    @if ($task->due_date)
        <p>Date limite : {{ $task->due_date->format('d/m/Y') }}</p>
    @endif

    @if (request()->user()->canManageClubOperations($club))
    <p>
        <a class="secondary-link" href="{{ route('clubs.tasks.edit', [$club, $task]) }}">Modifier la tache</a>
    </p>

    <form method="POST" action="{{ route('clubs.tasks.destroy', [$club, $task]) }}">
        @csrf
        @method('DELETE')

        <button class="danger-button" type="submit">Supprimer la tache</button>
    </form>
@endif

    <h2 class="section-title">Commentaires</h2>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('clubs.tasks.comments.store', [$club, $task]) }}">
    @csrf

    <div>
        <label class="form-label">Ajouter un commentaire</label>
        <textarea name="comment" required>{{ old('comment') }}</textarea>
    </div>

    <button class="form-button" type="submit">Commenter</button>
</form>

@if ($task->comments->isEmpty())
    <p>Aucun commentaire pour le moment.</p>
@else
    <ul>
        @foreach ($task->comments->sortByDesc('created_at') as $comment)
            <li>
                <strong>{{ $comment->user->name }}</strong>
                le {{ $comment->created_at->format('d/m/Y H:i') }}
                <br>
                {{ $comment->comment }}
            </li>
        @endforeach
    </ul>
@endif

    <p>
        <a class="simple-link" href="{{ route('clubs.tasks.index', $club) }}">Retour aux tâches</a>
    </p>
@endsection