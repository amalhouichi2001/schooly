<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche de paie - {{ $enseignant->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th, td { border: 1px solid #333; padding: 10px; text-align: left; }
        th { background-color: #f5f5f5; }
        .totals { margin-top: 20px; }
        .print-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        @media print {
            .print-btn { display: none; }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">📄 Imprimer ou Exporter en PDF</button>

    <h2>Fiche de paie : {{ $enseignant->name }}</h2>
    <p><strong>Date :</strong> {{ now()->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Montant (€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($enseignant->financialRecords as $record)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($record->type) }}</td>
                    <td>{{ number_format($record->montant, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p><strong>Total revenus :</strong>
            {{ number_format($enseignant->financialRecords->where('type', 'revenu')->sum('montant'), 2, ',', ' ') }} €
        </p>
        <p><strong>Total dépenses :</strong>
            {{ number_format($enseignant->financialRecords->where('type', 'dépense')->sum('montant'), 2, ',', ' ') }} €
        </p>
    </div>
</body>
</html>
