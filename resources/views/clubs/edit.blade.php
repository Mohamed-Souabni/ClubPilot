@extends('layouts.app')

@section('title', 'Modifier le club - ClubPilot')

@section('content')
    <h1 class="page-title">Modifier le club</h1>

    <form method="POST" action="{{ route('clubs.update', $club) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <label class="form-label">Nom du club</label>
        <input type="text" name="name" value="{{ old('name', $club->name) }}" required>

        <label class="form-label">Description</label>
        <textarea name="description">{{ old('description', $club->description) }}</textarea>

        @include('clubs.partials.logo-uploader', ['club' => $club])

        <button class="form-button" type="submit">Enregistrer</button>
    </form>

    <p>
        <a class="simple-link" href="{{ route('clubs.show', $club) }}">Retour au club</a>
    </p>
@endsection
