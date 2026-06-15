@extends('layouts.app')

@section('title', $event->title . ' - ClubPilot')

@section('content')
    <h1 class="page-title">{{ $event->title }}</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <p>Club : {{ $club->name }}</p>
    <p>Description : {{ $event->description }}</p>
    <p>Lieu : {{ $event->location }}</p>
    <p>Début : {{ $event->start_date->format('d/m/Y H:i') }}</p>

    @if ($event->end_date)
        <p>Fin : {{ $event->end_date->format('d/m/Y H:i') }}</p>
    @endif

    <p>Statut : {{ $event->status }}</p>
   

  @if (request()->user()->canManageClubOperations($club))
    <p>
        <a class="secondary-link" href="{{ route('clubs.events.attendance.qr', [$club, $event]) }}">
            Afficher le QR de présence
        </a>
    </p>

    <p>
        <a class="secondary-link" href="{{ route('clubs.events.attendances.index', [$club, $event]) }}">
            Voir la liste des présences
        </a>
    </p>
@endif

    @if (request()->user()->canManageClubOperations($club))
    <p>
        <a class="action-link" href="{{ route('clubs.events.edit', [$club, $event]) }}">Modifier l'evenement</a>
    </p>

    <form method="POST" action="{{ route('clubs.events.destroy', [$club, $event]) }}">
        @csrf
        @method('DELETE')

        <button class="danger-button" type="submit">Supprimer l'evenement</button>
    </form>
@endif
 <p>
        <a class="simple-link" href="{{ route('clubs.events.index', $club) }}">Retour aux événements</a>
    </p>
@endsection