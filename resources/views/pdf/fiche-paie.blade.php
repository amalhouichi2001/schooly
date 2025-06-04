<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche de paie - {{ $enseignant->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Fiche de paie - {{ $enseignant->name }}</h2>
    <p><strong>Mois :</strong> {{ \Carbon\Carbon::parse($groupedRecords->first()->date)->translatedFormat('F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Montant (€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedRecords as $record)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($record->type) }}</td>
                    <td>{{ number_format($record->montant, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 20px;"><strong>Total :</strong>
        {{ number_format($groupedRecords->sum('montant'), 2, ',', ' ') }} €
    </p>
</body>
</html>
