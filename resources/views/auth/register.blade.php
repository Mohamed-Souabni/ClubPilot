@extends('layouts.app')

@section('title', 'Inscription - ClubPilot')

@section('content')
    <h1 class="page-title"> Créer un compte</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label class="form-label">Nom complet</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button class="form-button" type="submit">S'inscrire</button>
    </form>

    <p>
        Déjà un compte ?
        <a class="action-link" href="{{ route('login') }}">Se connecter</a>
    </p>
@endsection