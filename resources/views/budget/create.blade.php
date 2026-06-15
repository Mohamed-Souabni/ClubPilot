@extends('layouts.app')

@section('title', 'Ajouter une transaction - ClubPilot')

@section('content')
    <h1 class="page-title"> Ajouter une transaction - {{ $club->name }}</h1>

   

    <form method="POST" action="{{ route('clubs.budget.store', $club) }}">
        @csrf

        <div>
            <label class="form-label">Type</label>
            <select name="type" required>
                <option value="income">Revenu</option>
                <option value="expense">Dépense</option>
            </select>
        </div>

        <div>
            <label class="form-label">Catégorie</label>
            <select name="category" required>
                <option value="event">Événement</option>
                <option value="material">Matériel</option>
                <option value="sponsorship">Sponsoring</option>
                <option value="transport">Transport</option>
                <option value="other">Autre</option>
            </select>
        </div>

        <div>
            <label class="form-label">Montant</label>
            <input type="number" name="amount" step="0.01" min="0.01" value="{{ old('amount') }}" required>
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="form-label">Date</label>
            <input type="date" name="transaction_date" value="{{ old('transaction_date') }}" required>
        </div>

        <button class="form-button" type="submit">Ajouter</button>
    </form>

    <p>
        <a class="simple-link" href="{{ route('clubs.budget.index', $club) }}">Retour au budget</a>
    </p>
@endsection