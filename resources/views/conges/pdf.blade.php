<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Demande de Congé</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { font-size: 20px; margin-bottom: 20px; }
        .field { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">Demande de Congé</div>

    <div class="field"><strong>Nom :</strong> {{ $conge->user->name }}</div>
    <div class="field"><strong>Type :</strong> {{ ucfirst($conge->type) }}</div>
    <div class="field"><strong>Date début :</strong> {{ $conge->date_debut }}</div>
    <div class="field"><strong>Date fin :</strong> {{ $conge->date_fin }}</div>
    <div class="field"><strong>Motif :</strong> {{ $conge->motif }}</div>
    <div class="field"><strong>Statut :</strong> {{ ucfirst($conge->statut) }}</div>
</body>
</html>
