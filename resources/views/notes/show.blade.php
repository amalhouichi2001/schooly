@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Détails de la note</h2>

    <!-- Affichage des détails de la note -->
    <div class="card">
        <div class="card-header">
            Détails de la note
        </div>
        <div class="card-body">
            <h5 class="card-title">Nom de l'élève : {{ $note->eleve->nom }}</h5>
            <p class="card-text"><strong>Matière :</strong> {{ $note->matiere }}</p>
            <p class="card-text"><strong>Note :</strong> {{ $note->valeur }}</p>
            <p class="card-text"><strong>Enseignant :</strong> {{ $note->enseignant->name }}</p>
            <p class="card-text"><strong>Classe :</strong> {{ $note->classe->nom ?? 'Aucune classe' }}</p>
            <p class="card-text"><strong>Date d'enregistrement :</strong> {{ $note->created_at }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('notes.index') }}" class="btn btn-secondary">Retour à la liste des notes</a>
        </div>
    </div>
</div>
@endsection
