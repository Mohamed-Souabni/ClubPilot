@extends('layouts.app')

@section('title', 'Notifications - ClubPilot')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Mes notifications</h1>
            <p>Consultez les messages envoyes par vos clubs et marquez-les comme lus.</p>
        </div>
    </div>

    @if ($notifications->isEmpty())
        <div class="empty-state">
            <p>Aucune notification pour le moment.</p>
        </div>
    @else
        <div class="notification-list">
            @foreach ($notifications as $notification)
                <article class="notification-card @if (! $notification->is_read) is-unread @endif">
                    <div class="notification-card-header">
                        <div>
                            <strong>{{ $notification->title }}</strong>
                            <span>{{ $notification->club?->name ?? 'General' }}</span>
                        </div>

                        @if (! $notification->is_read)
                            <span class="status-badge status-unread">Non lue</span>
                        @else
                            <span class="status-badge status-read">Lue</span>
                        @endif
                    </div>

                    <p>{{ $notification->message }}</p>
                    <small>{{ $notification->created_at->format('d/m/Y H:i') }}</small>

                    @if (! $notification->is_read)
                        <form class="inline-form" method="POST" action="{{ route('notifications.read', $notification) }}">
                            @csrf
                            @method('PATCH')
                            <button class="form-button" type="submit">Marquer comme lue</button>
                        </form>
                    @endif
                </article>
            @endforeach
        </div>
    @endif

    <p>
        <a class="simple-link" href="{{ route('dashboard') }}">Retour a mon espace</a>
    </p>
@endsection
