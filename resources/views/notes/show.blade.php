@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Détails de la note</h2>

    <!-- Affichage des détails de la note -->
    <div class="card">
        <div class="card-header">
            Détails de la note
        </div>
       
    <div class="container">
        <h2>Détail de la Note</h2>
        <p><strong>Élève :</strong> {{ $note->eleve->name ?? 'Inconnu' }}</p>
        <p><strong>Matière :</strong> {{ $note->matiere->nom ?? 'Inconnue' }}</p>
        <p><strong>Valeur :</strong> {{ $note->note }}</p>
        <p><strong>Classe :</strong> {{ $note->classe->nom ?? 'Non définie' }}</p>
    </div>

        <div class="card-footer">
            <a href="{{ route('notes.index') }}" class="btn btn-secondary">Retour à la liste des notes</a>
        </div>
    </div>
</div>
@endsection
