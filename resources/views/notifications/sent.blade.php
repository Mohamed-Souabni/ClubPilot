@extends('layouts.app')

@section('title', 'Messages envoyes - ClubPilot')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Messages envoyes - {{ $club->name }}</h1>
            <p>Suivez les notifications envoyees et voyez combien de membres les ont lues.</p>
        </div>

        <div class="page-header-actions">
            <a class="action-link" href="{{ route('clubs.notifications.create', $club) }}">Nouveau message</a>
            <a class="simple-link" href="{{ route('clubs.show', $club) }}">Retour au club</a>
        </div>
    </div>

    @if ($sentMessages->isEmpty())
        <div class="empty-state">
            <p>Aucun message envoye pour le moment.</p>
        </div>
    @else
        <div class="sent-message-grid">
            @foreach ($sentMessages as $message)
                @php
                    $readPercent = $message['total_count'] > 0
                        ? round(($message['read_count'] / $message['total_count']) * 100)
                        : 0;
                @endphp

                <article class="sent-message-card">
                    <div class="sent-message-card-header">
                        <div>
                            <h3>{{ $message['title'] }}</h3>
                            <span>
                                Envoye le {{ $message['created_at']->format('d/m/Y H:i') }}
                                @if ($message['creator'])
                                    par {{ $message['creator']->name }}
                                @endif
                            </span>
                        </div>

                        <strong>{{ $message['read_count'] }}/{{ $message['total_count'] }} lus</strong>
                    </div>

                    <p>{{ \Illuminate\Support\Str::limit($message['message'], 150) }}</p>

                    <div class="read-meter" aria-label="Progression de lecture">
                        <span style="width: {{ $readPercent }}%"></span>
                    </div>

                    <div class="notification-stats">
                        <span class="status-badge status-read">{{ $message['read_count'] }} lu(s)</span>
                        <span class="status-badge status-unread">{{ $message['unread_count'] }} non lu(s)</span>
                    </div>

                    <a class="secondary-link" href="{{ route('clubs.notifications.readers', [$club, $message['batch_id']]) }}">
                        Voir les lecteurs
                    </a>
                </article>
            @endforeach
        </div>
    @endif
@endsection
