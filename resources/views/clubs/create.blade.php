@extends('layouts.app')

@section('title', 'Créer un club - ClubPilot')

@section('content')
    <h1 class="page-title"> Créer un club</h1>

    

    <form method="POST" action="{{ route('clubs.store') }}" enctype="multipart/form-data">
        @csrf
        @include('clubs.partials.logo-uploader')
        
        <div>
            <label class="form-label">Nom du club</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <button class="form-button" type="submit">Créer le club</button>
    </form>

    <p>
        <a class="simple-link" href="{{ route('dashboard') }}">Retour a mon espace</a>
    </p>
@endsection
