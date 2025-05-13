@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier Enseignant</h2>

    <form action="{{ route('enseignants.update', $enseignant->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ $enseignant->nom }}" required>
        </div>

        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ $enseignant->prenom }}" required>
        </div>

        <div class="mb-3">
            <label for="specialite" class="form-label">Spécialité</label>
            <input type="text" name="specialite" class="form-control" value="{{ $enseignant->specialite }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('enseignants.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
