@extends('layouts.app')

@section('title', 'Créer un événement - ClubPilot')

@section('content')
    <h1 class="page-title">Créer un événement - {{ $club->name }}</h1>

    <form method="POST" action="{{ route('clubs.events.store', $club) }}">
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
            <label class="form-label">Lieu</label>
            <input type="text" name="location" value="{{ old('location') }}">
        </div>

        <div>
            <label class="form-label">Date de début</label>
            <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required>
        </div>

        <div>
            <label class="form-label">Date de fin</label>
            <input type="datetime-local" name="end_date" value="{{ old('end_date') }}">
        </div>

        <div>
            <label class="form-label">Statut</label>
            <select name="status" required>
                <option value="planned">Planifié</option>
                <option value="ongoing">En cours</option>
                <option value="finished">Terminé</option>
                <option value="cancelled">Annulé</option>
            </select>
        </div>

        <button class="form-button" type="submit">Créer l'événement</button>
    </form>

    <p>
        <a class="simple-link" href="{{ route('clubs.events.index', $club) }}">Retour aux événements</a>
    </p>
@endsection