@extends('layouts.app')

@section('title', 'Connexion - ClubPilot')

@section('content')
    <h1 class="page-title"> Se connecter</h1>


    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label class="form-label">
                <input type="checkbox" name="remember">
                Se souvenir de moi
            </label>
        </div>

        <button class="form-button" type="submit">Se connecter</button>
    </form>

    <p>
        Pas encore de compte ?
        <a class="action-link" href="{{ route('register') }}">Créer un compte</a>
    </p>
@endsection