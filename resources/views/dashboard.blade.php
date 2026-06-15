@extends('layouts.app')

@section('title', 'Dashboard - ClubPilot')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Mon espace</h1>
            <p>Bienvenue, {{ auth()->user()->name }}.</p>
        </div>

        <div class="page-header-actions">
            <a class="secondary-link" href="{{ route('clubs.browse') }}">Explorer les clubs</a>
            <a class="action-link" href="{{ route('clubs.create') }}">Créer un club</a>
        </div>
    </div>

    <h2 class="section-title">Mes clubs</h2>

    @if ($clubs->isEmpty())
        <div class="empty-state">
            <p>Vous n'appartenez encore à aucun club.</p>
            <a class="action-link" href="{{ route('clubs.browse') }}">Explorer les clubs</a>
        </div>
    @else
        <div class="club-grid featured-club-grid">
            @foreach ($clubs as $club)
                <article class="club-card featured-club-card">
                    <div class="club-card-visual">
                        @if ($club->logo)
                            <img class="club-card-logo-large" src="{{ asset('storage/' . $club->logo) }}" alt="Logo {{ $club->name }}">
                        @else
                            <div class="club-card-logo-large-fallback">{{ strtoupper(substr($club->name, 0, 2)) }}</div>
                        @endif
                    </div>

                    <div class="club-card-body">
                        <div class="club-card-title-row">
                            <h3 class="club-card-title">{{ $club->name }}</h3>
                            <span class="status-badge status-{{ $club->pivot->status }}">
                                {{ $club->pivot->status }}
                            </span>
                        </div>

                        <p class="club-description">
                            {{ $club->description ?? 'Aucune description disponible.' }}
                        </p>

                        <div class="club-meta">
                            <span>Rôle : {{ $club->pivot->role }}</span>
                            @if ($club->pivot->joined_at)
                                <span>Depuis : {{ \Carbon\Carbon::parse($club->pivot->joined_at)->format('d/m/Y') }}</span>
                            @endif
                        </div>

                        <div class="club-actions">
                            <a class="secondary-link" href="{{ route('clubs.show', $club) }}">Ouvrir</a>

                            @if ($club->pivot->status === 'active')
                                <a class="secondary-link" href="{{ route('clubs.dashboard', $club) }}">Dashboard</a>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
