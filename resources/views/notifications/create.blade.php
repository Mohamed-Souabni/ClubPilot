@extends('layouts.app')

@section('title', 'Envoyer une notification - ClubPilot')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Envoyer une notification - {{ $club->name }}</h1>
            <p>Le message sera envoye aux membres actifs du club.</p>
        </div>

        <div class="page-header-actions">
            <a class="secondary-link" href="{{ route('clubs.notifications.sent', $club) }}">Messages envoyes</a>
            <a class="simple-link" href="{{ route('clubs.show', $club) }}">Retour au club</a>
        </div>
    </div>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('clubs.notifications.store', $club) }}">
        @csrf

        <div>
            <label class="form-label">Titre</label>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>

        <div>
            <label class="form-label">Message</label>
            <textarea name="message" required>{{ old('message') }}</textarea>
        </div>

        <button class="form-button" type="submit">Envoyer</button>
    </form>
@endsection
