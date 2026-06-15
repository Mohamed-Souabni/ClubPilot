@extends('layouts.app')

@section('title', 'Modifier un evenement - ClubPilot')

@section('content')
    <h1 class="page-title">Modifier un evenement - {{ $club->name }}</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('clubs.events.update', [$club, $event]) }}">
        @csrf
        @method('PATCH')

        <div>
            <label class="form-label">Titre</label>
            <input type="text" name="title" value="{{ old('title', $event->title) }}" required>
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description">{{ old('description', $event->description) }}</textarea>
        </div>

        <div>
            <label class="form-label">Lieu</label>
            <input type="text" name="location" value="{{ old('location', $event->location) }}">
        </div>

        <div>
            <label class="form-label">Date de debut</label>
            <input type="datetime-local" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div>
            <label class="form-label">Date de fin</label>
            <input type="datetime-local" name="end_date" value="{{ old('end_date', $event->end_date?->format('Y-m-d\TH:i')) }}">
        </div>

        <div>
            <label class="form-label">Statut</label>
            <select name="status" required>
                <option value="planned" @selected(old('status', $event->status) === 'planned')>Planifié</option>
                <option value="ongoing" @selected(old('status', $event->status) === 'ongoing')>En cours</option>
                <option value="finished" @selected(old('status', $event->status) === 'finished')>Terminé</option>
                <option value="cancelled" @selected(old('status', $event->status) === 'cancelled')>Annulé</option>
            </select>
        </div>

        <button type="submit">Modifier</button>
    </form>

    <p>
        <a class="simple-link" href="{{ route('clubs.events.show', [$club, $event]) }}">Retour a l'evenement</a>
    </p>
@endsection