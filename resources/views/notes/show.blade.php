@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h4>Détail de la note</h4>
        </div>
        <div class="card-body">

            <p><strong>Élève :</strong> {{ $note->eleve->nom }} {{ $note->eleve->prenom }}</p>

            <p><strong>Matière :</strong> {{ $note->matiere->nom }}</p>

            <p><strong>Classe :</strong> {{ $note->classe->nom }}</p>

            <p><strong>Note :</strong> {{ $note->note }}/20</p>

            <p><strong>Enseignant :</strong> {{ $note->enseignant->name ?? 'Inconnu' }}</p>

            <p><strong>Date d’ajout :</strong> {{ $note->created_at->format('d/m/Y H:i') }}</p>

            <a href="{{ route('notes.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
        </div>
    </div>
</div>
@endsection
