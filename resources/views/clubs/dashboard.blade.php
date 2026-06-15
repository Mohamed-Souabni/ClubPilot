@extends('layouts.app')

@section('title', 'Dashboard club - ClubPilot')

@section('content')
   <div class="page-header">
    <div class="club-hero">
        @if ($club->logo)
            <img class="club-logo-large" src="{{ asset('storage/' . $club->logo) }}" alt="Logo {{ $club->name }}">
        @else
            <div class="club-logo-fallback">{{ strtoupper(substr($club->name, 0, 2)) }}</div>
        @endif

        <div>
            <h1 class="page-title">Dashboard - {{ $club->name }}</h1>
            <p>{{ $club->description ?? 'Vue synthétique du club.' }}</p>
        </div>
    </div>

    <div class="page-header-actions">
        <a class="simple-link" href="{{ route('clubs.show', $club) }}">Retour au club</a>
    </div>
</div>

<h2 class="section-title"> Alertes</h2>

@if (! $nextEvent && $lateTasks->isEmpty() && $mySoonTasks->isEmpty() && ! $budgetIsLow)
    <p>Aucune alerte importante pour le moment.</p>
@else
    <ul>
        @if ($budgetIsLow)
            <li>
                Budget faible : {{ number_format($balance, 2) }} MAD restants.
            </li>
        @endif

        @if ($nextEvent)
            <li>
                Événement proche :
                <a class="secondary-link" href="{{ route('clubs.events.show', [$club, $nextEvent]) }}">
                    {{ $nextEvent->title }}
                </a>
                le {{ $nextEvent->start_date->format('d/m/Y H:i') }}.
            </li>
        @endif

        @if ($lateTasks->isNotEmpty())
            <li>
                {{ $lateTasks->count() }} tâche(s) en retard dans le club.
            </li>
        @endif

        @if ($mySoonTasks->isNotEmpty())
            <li>
                Vous avez {{ $mySoonTasks->count() }} tâche(s) bientôt à rendre.
            </li>
        @endif
    </ul>
@endif

    <h2 class="section-title"> Résumé</h2>

    <ul>
        <li>Membres actifs : {{ $activeMembersCount }}</li>
        <li>Tâches en retard : {{ $lateTasksCount }}</li>

        @if (! is_null($balance))
            <li>Budget restant : {{ number_format($balance, 2) }} MAD</li>
        @endif
    </ul>

    <h2 class="section-title"> Événements à venir</h2>

    @if ($upcomingEvents->isEmpty())
        <p>Aucun événement à venir.</p>
    @else
        <ul>
            @foreach ($upcomingEvents as $event)
                <li>
                    <a class="secondary-link" href="{{ route('clubs.events.show', [$club, $event]) }}">
                        {{ $event->title }}
                    </a>
                    - {{ $event->start_date->format('d/m/Y H:i') }}
                </li>
            @endforeach
        </ul>
    @endif

    <h2 class="section-title"> Mes tâches en cours</h2>

    @if ($myTasks->isEmpty())
        <p>Aucune tâche en cours.</p>
    @else
        <ul>
            @foreach ($myTasks as $task)
                <li>
                    <a href="{{ route('clubs.tasks.show', [$club, $task]) }}">
                        {{ $task->title }}
                    </a>
                    - priorité : {{ $task->priority }}
                    @if ($task->due_date)
                        - limite : {{ $task->due_date->format('d/m/Y') }}
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    
@endsection