@extends('layouts.app')

@section('title', 'Membres - ClubPilot')

@section('content')
    <h1 class="page-title"> Membres - {{ $club->name }}</h1>

    <form method="GET" action="{{ route('clubs.members.index', $club) }}">
    <input type="text" name="search" placeholder="Rechercher nom ou email" value="{{ request('search') }}">

    <select name="role">
        <option value="">Tous les rôles</option>
        <option value="president" @selected(request('role') === 'president')>Président</option>
        <option value="admin" @selected(request('role') === 'admin')>Admin club</option>
        <option value="member" @selected(request('role') === 'member')>Membre</option>
    </select>

    <select name="status">
        <option value="">Tous les statuts</option>
        <option value="active" @selected(request('status') === 'active')>Actif</option>
        <option value="inactive" @selected(request('status') === 'inactive')>Inactif</option>
    </select>

    <button class="form-button" type="submit">Filtrer</button>
    <a class="form-button" href="{{ route('clubs.members.index', $club) }}">Réinitialiser</a>
</form>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($memberships->isEmpty())
        <p>Aucun membre pour le moment.</p>
    @else
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Statut</th>
                    <th>Date adhesion</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($memberships as $membership)
                    <tr>
                        <td>{{ $membership->user->name }}</td>
                        <td>{{ $membership->user->email }}</td>
                        <td>{{ $membership->role }}</td>
                        <td>{{ $membership->status }}</td>
                        <td>{{ $membership->joined_at?->format('d/m/Y H:i') ?? '-' }}</td>
                        <td>
                            @if ($membership->role === 'president')
                                President principal
                            @else
                                <form method="POST" action="{{ route('clubs.members.update', [$club, $membership]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <select name="role">
                                        <option value="member" @selected($membership->role === 'member')>Membre</option>
                                        <option value="admin" @selected($membership->role === 'admin')>Admin club</option>
                                    </select>

                                    <select name="status">
                                        <option value="active" @selected($membership->status === 'active')>Actif</option>
                                        <option value="inactive" @selected($membership->status === 'inactive')>Inactif</option>
                                    </select>

                                    <button class="form-button" type="submit">Modifier</button>
                                </form>

                                <form method="POST" action="{{ route('clubs.members.destroy', [$club, $membership]) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="form-button" type="submit">Retirer</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p>
        <a class="secondary-link" class="secondary-link"  href="{{ route('clubs.membership-requests', $club) }}">Voir les demandes d'adhesion</a>
    </p>

    <p>
        <a class="simple-link" href="{{ route('clubs.show', $club) }}">Retour au club</a>
    </p>
@endsection