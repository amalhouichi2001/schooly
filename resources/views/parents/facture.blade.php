<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>

    <h2>Facture de Paiement</h2>
    <p><strong>Nom du parent :</strong> {{ $inscription->eleve->parent->nom }}</p>
    <p><strong>Enfant :</strong> {{ $inscription->eleve->nom }}</p>
    <p><strong>Date d'inscription :</strong> {{ $inscription->date_inscription->format('d/m/Y') }}</p>
    <p><strong>Mode de paiement :</strong> {{ ucfirst($inscription->mode_paiement) }}</p>

    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Frais d'inscription</td>
                <td>100 TND</td> {{-- adapte selon ton système --}}
            </tr>
        </tbody>
    </table>

    <p style="margin-top: 30px;">Merci pour votre paiement.</p>

</body>
</html>
