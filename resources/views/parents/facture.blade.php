<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Facture Paiement</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }
    </style>
</head>

<body>
    <h2>Facture de Paiement</h2>
    <p>Nom de l'élève : {{ $inscription->eleve?->name ?? 'Inconnu' }}</p>
    <p>Date d'inscription : {{ $inscription->date_inscription }}</p>
    <p>Statut : {{ $inscription->statut }}</p>
    <p>Montant payé : 100.00 TND</p>

    <p>Date de génération : {{ now()->format('d/m/Y') }}</p>
</body>

</html>