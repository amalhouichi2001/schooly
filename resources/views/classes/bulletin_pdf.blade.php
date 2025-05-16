<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin de la classe : {{ $classe->nom }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        .moyenne { margin: 20px 0; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Bulletin de la classe : {{ $classe->nom }}</h2>

    @if($moyenne !== null)
        <p class="moyenne">Moyenne générale de la classe : {{ $moyenne }}/20</p>
    @endif

    <h3>{{ $eleve->name }} ({{ $eleve->email }})</h3>

    @if($notes->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Enseignant</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notes as $note)
                    <tr>
                        <td>{{ $note->matiere->nom ?? 'N/A' }}</td>
                        <td>{{ $note->enseignant->name ?? 'N/A' }}</td>
                        <td>{{ $note->note }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center;">Aucune note disponible pour cet élève.</p>
    @endif

</body>
</html>
