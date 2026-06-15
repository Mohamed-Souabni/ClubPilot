@extends('layouts.app')

@section('title', 'QR presence - ClubPilot')

@section('content')
    <h1 class="page-title"> QR presence - {{ $event->title }}</h1>

    <img src="{{ $qrCode }}" alt="QR code de presence">

    <p>Lien de scan : {{ $scanUrl }}</p>

    <p>
        <a class="simple-link" href="{{ route('clubs.events.show', [$club, $event]) }}">Retour a l'evenement</a>
    </p>
@endsection