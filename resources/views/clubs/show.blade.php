@extends('layouts.app')

@section('title', $club->name . ' - ClubPilot')

@section('content')

@php
    $user = request()->user();
    $isActiveMember = $user->isActiveMemberOf($club);
    $isPresident = $user->isPresidentOf($club);
    $canManageOperations = $user->canManageClubOperations($club);
@endphp

<div class="page-header">
    <div class="club-hero">
        @if ($club->logo)
            <img class="club-logo-large" src="{{ asset('storage/' . $club->logo) }}" alt="Logo {{ $club->name }}">
        @else
            <div class="club-logo-fallback">{{ strtoupper(substr($club->name, 0, 2)) }}</div>
        @endif

        <div>
            <h1 class="page-title">{{ $club->name }}</h1>
            <p>{{ $club->description ?? 'Aucune description disponible.' }}</p>
        </div>
    </div>

    <div class="page-header-actions">
        @if ($isPresident)
            <a class="secondary-link" href="{{ route('clubs.edit', $club) }}">Modifier le club</a>
        @endif

        <a class="simple-link" href="{{ route('dashboard') }}">Retour a mon espace</a>
    </div>
</div>

@if ($isActiveMember)
    <div class="module-grid">
        <div class="module-card">
            <h3>Dashboard</h3>
            <p>Voir les statistiques, alertes, événements proches et tâches importantes.</p>
            <a class="secondary-link" href="{{ route('clubs.dashboard', $club) }}">Ouvrir</a>
        </div>

        <div class="module-card">
            <h3>Événements</h3>
            <p>Consulter les événements du club et gérer les présences.</p>
            <a class="secondary-link" href="{{ route('clubs.events.index', $club) }}">Ouvrir</a>
        </div>

        <div class="module-card">
            <h3>Tâches</h3>
            <p>Consulter les tâches, suivre leur avancement et commenter.</p>
            <a class="secondary-link" href="{{ route('clubs.tasks.index', $club) }}">Ouvrir</a>
        </div>

        @if ($isPresident)
            <div class="module-card">
                <h3>Membres</h3>
                <p>Gérer les membres, rôles, statuts et demandes d’adhésion.</p>
                <a class="secondary-link" href="{{ route('clubs.members.index', $club) }}">Ouvrir</a>
            </div>

            <div class="module-card">
                <h3>Budget</h3>
                <p>Suivre les revenus, dépenses, catégories et solde du club.</p>
                <a class="secondary-link" href="{{ route('clubs.budget.index', $club) }}">Ouvrir</a>
            </div>
        @endif

        @if ($canManageOperations)
            <div class="module-card">
                <h3>Notifications</h3>
                <p>Envoyer des messages aux membres et suivre qui les a lus.</p>
                <div class="module-actions">
                    <a class="secondary-link" href="{{ route('clubs.notifications.create', $club) }}">Envoyer</a>
                    <a class="secondary-link" href="{{ route('clubs.notifications.sent', $club) }}">Lectures</a>
                </div>
            </div>
        @endif
    </div>
@else
    <p>Vous n’êtes pas encore membre actif de ce club.</p>
@endif
@endsection
