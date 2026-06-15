@extends('layouts.app')

@section('title', 'Lecteurs du message - ClubPilot')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Lecteurs du message</h1>
            <p>{{ $club->name }}</p>
        </div>

        <div class="page-header-actions">
            <a class="simple-link" href="{{ route('clubs.notifications.sent', $club) }}">Retour aux messages</a>
        </div>
    </div>

    <div class="message-preview-card">
        <span>Message</span>
        <h2>{{ $message->title }}</h2>
        <p>{{ $message->message }}</p>
        <small>Envoye le {{ $message->created_at->format('d/m/Y H:i') }}</small>
    </div>

    <table class="readers-table">
        <thead>
            <tr>
                <th>Membre</th>
                <th>Email</th>
                <th>Statut</th>
                <th>Date de lecture</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notifications as $notification)
                <tr>
                    <td>{{ $notification->user?->name ?? 'Utilisateur supprime' }}</td>
                    <td>{{ $notification->user?->email ?? '-' }}</td>
                    <td>
                        @if ($notification->is_read)
                            <span class="status-badge status-read">Lu</span>
                        @else
                            <span class="status-badge status-unread">Non lu</span>
                        @endif
                    </td>
                    <td>
                        {{ $notification->read_at ? $notification->read_at->format('d/m/Y H:i') : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
