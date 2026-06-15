@extends('layouts.app')

@section('title', 'Budget - ClubPilot')

@section('content')
    <h1 class="page-title"> Budget - {{ $club->name }}</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <p>Total revenus : {{ number_format($totalIncome, 2) }} MAD</p>
    <p>Total depenses : {{ number_format($totalExpense, 2) }} MAD</p>
    <p>Solde : {{ number_format($balance, 2) }} MAD</p>

    <p>
        <a class="action-link" href="{{ route('clubs.budget.create', $club) }}">Ajouter une transaction</a>
    </p>

    @if ($transactions->isEmpty())
        <p>Aucune transaction pour le moment.</p>
    @else
        <ul>
            @foreach ($transactions as $transaction)
               <li>
                    {{ $transaction->transaction_date->format('d/m/Y') }}
                    - {{ $transaction->type }}
                    - {{ $transaction->category }}
                    - {{ number_format($transaction->amount, 2) }} MAD
                    - {{ $transaction->description }}

            <a class="secondary-link" href="{{ route('clubs.budget.edit', [$club, $transaction]) }}">Modifier</a>

            <form method="POST" action="{{ route('clubs.budget.destroy', [$club, $transaction]) }}" style="display:inline;">
              @csrf
                 @method('DELETE')

             <button class="danger-button" type="submit">Supprimer</button>
                 </form>
                </li>
            @endforeach
        </ul>
    @endif

    <p>
        <a class="simple-link" href="{{ route('clubs.show', $club) }}">Retour au club</a>
    </p>
@endsection