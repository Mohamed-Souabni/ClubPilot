@extends('layouts.app')

@section('title', 'Liste des presences - ClubPilot')

@section('content')
    <h1 class="page-title"> Liste des presences</h1>
 <p>
    <a class="action-link" href="{{ route('clubs.events.attendances.pdf', [$club, $event]) }}">
        Exporter les présences en PDF
    </a>
</p>
    <p>Evenement : {{ $event->title }}</p>
    <p>Club : {{ $club->name }}</p>

    <p>Total presents : {{ $attendances->count() }}</p>

    @if ($attendances->isEmpty())
        <p>Aucune presence enregistree pour cet evenement.</p>
    @else
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Date de confirmation</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->user->name }}</td>
                        <td>{{ $attendance->user->email }}</td>
                        <td>{{ $attendance->checked_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p>
        <a class="simple-link" href="{{ route('clubs.events.show', [$club, $event]) }}">
            Retour a l'evenement
        </a>
    </p>
@endsection