@extends('layouts.app')

@section('title', 'Modifier une tache - ClubPilot')

@section('content')
    <h1 class="page-title">Modifier une tache - {{ $club->name }}</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('clubs.tasks.update', [$club, $task]) }}">
        @csrf
        @method('PATCH')

        <div>
            <label class="form-label">Titre</label>
            <input type="text" name="title" value="{{ old('title', $task->title) }}" required>
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description">{{ old('description', $task->description) }}</textarea>
        </div>

        <div>
            <label class="form-label">Assigner a</label>
            <select name="assigned_to">
                <option value="">Non assignee</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" @selected(old('assigned_to', $task->assigned_to) == $member->id)>
                        {{ $member->name }} - {{ $member->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label">Statut</label>
            <select name="status" required>
                <option value="todo" @selected(old('status', $task->status) === 'todo')>A faire</option>
                <option value="in_progress" @selected(old('status', $task->status) === 'in_progress')>En cours</option>
                <option value="done" @selected(old('status', $task->status) === 'done')>Terminee</option>
            </select>
        </div>

        <div>
            <label class="form-label">Priorite</label>
            <select name="priority" required>
                <option value="low" @selected(old('priority', $task->priority) === 'low')>Basse</option>
                <option value="medium" @selected(old('priority', $task->priority) === 'medium')>Moyenne</option>
                <option value="high" @selected(old('priority', $task->priority) === 'high')>Haute</option>
            </select>
        </div>

        <div>
            <label class="form-label">Date limite</label>
            <input type="date" name="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
        </div>

        <button class="form-button" type="submit">Modifier</button>
    </form>

    <p>
        <a class="simple-link" href="{{ route('clubs.tasks.show', [$club, $task]) }}">Retour a la tache</a>
    </p>
@endsection