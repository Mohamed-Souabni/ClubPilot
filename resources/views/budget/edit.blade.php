@extends('layouts.app')

@section('title', 'Modifier transaction - ClubPilot')

@section('content')
    <h1 class="page-title"> Modifier transaction - {{ $club->name }}</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('clubs.budget.update', [$club, $budgetTransaction]) }}">
        @csrf
        @method('PATCH')

        <div>
            <label class="form-label">Type</label>
            <select name="type" required>
                <option value="income" @selected(old('type', $budgetTransaction->type) === 'income')>Revenu</option>
                <option value="expense" @selected(old('type', $budgetTransaction->type) === 'expense')>Depense</option>
            </select>
        </div>

        <div>
            <label class="form-label">Categorie</label>
            <select name="category" required>
                <option value="event" @selected(old('category', $budgetTransaction->category) === 'event')>Evenement</option>
                <option value="material" @selected(old('category', $budgetTransaction->category) === 'material')>Materiel</option>
                <option value="sponsorship" @selected(old('category', $budgetTransaction->category) === 'sponsorship')>Sponsoring</option>
                <option value="transport" @selected(old('category', $budgetTransaction->category) === 'transport')>Transport</option>
                <option value="other" @selected(old('category', $budgetTransaction->category) === 'other')>Autre</option>
            </select>
        </div>

        <div>
            <label class="form-label">Montant</label>
            <input type="number" name="amount" step="0.01" min="0.01" value="{{ old('amount', $budgetTransaction->amount) }}" required>
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description">{{ old('description', $budgetTransaction->description) }}</textarea>
        </div>

        <div>
            <label class="form-label">Date</label>
            <input type="date" name="transaction_date" value="{{ old('transaction_date', $budgetTransaction->transaction_date->format('Y-m-d')) }}" required>
        </div>

        <button class="form-button" type="submit">Modifier</button>
    </form>

    <p>
        <a class="simple-link" href="{{ route('clubs.budget.index', $club) }}">Retour au budget</a>
    </p>
@endsection