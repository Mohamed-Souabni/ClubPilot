<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h1 { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #eeeeee; }
    </style>
</head>
<body>
    <h1 class="page-title">Liste des présences</h1>

    <div class="info">
        <p><strong>Club :</strong> {{ $club->name }}</p>
        <p><strong>Événement :</strong> {{ $event->title }}</p>
        <p><strong>Date :</strong> {{ $event->start_date->format('d/m/Y H:i') }}</p>
        <p><strong>Total présents :</strong> {{ $attendances->count() }}</p>
    </div>

    @if ($attendances->isEmpty())
        <p>Aucune présence enregistrée.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Heure de validation</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->user->name }}</td>
                        <td>{{ $attendance->user->email }}</td>
                        <td>{{ $attendance->checked_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>