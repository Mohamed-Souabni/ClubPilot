@extends('layouts.app')

@section('title', 'Confirmer presence - ClubPilot')

@section('content')
    <h1 class="page-title"> Confirmer ma presence</h1>

    <p>Evenement : {{ $event->title }}</p>
    <p>Club : {{ $club->name }}</p>

    <form method="POST" action="{{ route('attendance.store', $event->qr_code) }}">
        @csrf
        <button class="form-button" type="submit">Confirmer ma presence</button>
    </form>
@endsection