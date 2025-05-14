@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Détails de la séance</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Date:</strong> {{ $seance->date }}</p>
            <p><strong>Heure:</strong> {{ $seance->heure_debut }} - {{ $seance->heure_fin }}</p>
            <p><strong>Durée:</strong> {{ $seance->duration }} min</p>
            <p><strong>Classe:</strong> {{ $seance->classe->nom ?? '---' }}</p>
            <p><strong>Enseignant:</strong> {{ $seance->enseignant->name ?? '---' }}</p>
            <p><strong>Matière:</strong> {{ $seance->matiere->nom ?? '' }}</p>
            <p><strong>Salle:</strong> {{ $seance->salle->nom ?? '' }}</p>
            <p><strong>Type:</strong> {{ ucfirst($seance->type) }}</p>
        </div>
    </div>
    <a href="{{ route('seances.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection
