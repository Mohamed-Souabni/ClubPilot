@extends('layouts.app')

@section('title', 'Explorer les clubs - ClubPilot')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Explorer les clubs</h1>
            <p>Découvrez les clubs disponibles et envoyez une demande d'adhésion aux clubs qui vous intéressent.</p>
        </div>

        <div class="page-header-actions">
            <a class="simple-link" href="{{ route('dashboard') }}">Retour a mon espace</a>
        </div>
    </div>

    @if ($clubs->isEmpty())
        <div class="empty-state">
            <p>Aucun club disponible pour le moment.</p>
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
                            <span class="status-badge status-active">
                                {{ $club->active_members_count }} membre(s)
                            </span>
                        </div>

                        <p class="club-description">
                            {{ $club->description ?? 'Aucune description disponible.' }}
                        </p>

                        <div class="club-actions">
                            @if (in_array($club->id, $userClubIds))
                                <span class="status-badge status-pending">Relation existante</span>
                            @else
                                <form method="POST" action="{{ route('clubs.join', $club) }}">
                                    @csrf
                                    <button class="form-button" type="submit">Demander à rejoindre</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
