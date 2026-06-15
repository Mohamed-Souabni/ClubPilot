@extends('layouts.app')

@section('title', 'Profil - ClubPilot')

@section('content')
    <h1 class="page-title">Mon profil</h1>

    <h2 class="section-title">Informations personnelles</h2>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div>
            <label class="form-label">Nom</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <button class="form-button" type="submit">Modifier le profil</button>
    </form>

    <h2 class="section-title">Modifier le mot de passe</h2>

    <form method="POST" action="{{ route('profile.password') }}">
        @csrf
        @method('PATCH')

        <div>
            <label class="form-label">Mot de passe actuel</label>
            <input type="password" name="current_password" required>
        </div>

        <div>
            <label class="form-label">Nouveau mot de passe</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label class="form-label">Confirmer le nouveau mot de passe</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button class="form-button" type="submit">Modifier le mot de passe</button>
    </form>

    <p>
        <a class="simple-link" href="{{ route('dashboard') }}">Retour au dashboard</a>
    </p>
@endsection