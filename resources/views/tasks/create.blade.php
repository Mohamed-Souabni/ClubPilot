@extends('layouts.app')

@section('title', 'Créer une tâche - ClubPilot')

@section('content')
    <h1 class="page-title">Créer une tâche - {{ $club->name }}</h1>


    <form method="POST" action="{{ route('clubs.tasks.store', $club) }}">
        @csrf

        <div>
            <label class="form-label">Titre</label>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="form-label">Assigner à</label>
            <select name="assigned_to">
                <option value="">Non assignée</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">
                        {{ $member->name }} - {{ $member->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label">Statut</label>
            <select name="status" required>
                <option value="to_do">À faire</option>
                <option value="in_progress">En cours</option>
                <option value="done">Terminée</option>
            </select>
        </div>

        <div>
            <label class="form-label">Priorité</label>
            <select name="priority" required>
                <option value="low">Basse</option>
                <option value="medium" selected>Moyenne</option>
                <option value="high">Haute</option>
            </select>
        </div>

        <div>
            <label class="form-label">Date limite</label>
            <input type="date" name="due_date" value="{{ old('due_date') }}">
        </div>

        <button class="form-button" type="submit">Créer la tâche</button>
    </form>

    <p>
        <a class="simple-link" href="{{ route('clubs.tasks.index', $club) }}">Retour aux tâches</a>
    </p>
@endsection