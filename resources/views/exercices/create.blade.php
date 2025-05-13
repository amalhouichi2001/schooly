@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Créer un Nouvel Exercice</h2>

    {{-- Affichage des erreurs de validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oups !</strong> Il y a des erreurs dans votre saisie.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire de création --}}
    <form action="{{ route('exercices.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="titre" class="form-label">Exercice</label>
            <input type="text" name="titre" class="form-control" id="titre" value="{{ old('titre') }}" required>
        </div>

        <div class="mb-3">
            <label for="classe_id" class="form-label">Classe</label>
            <select name="classe_id" id="classe_id" class="form-select" required>
                <option value="">-- Sélectionner une classe --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date_limite" class="form-label">Date Limite</label>
            <input type="date" name="date_limite" class="form-control" id="date_limite" value="{{ old('date_limite') }}" required>
        </div>
        <div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" class="form-control" required></textarea>
</div>


        {{-- Champ d'import de fichier --}}
        <div class="mb-3">
            <label for="fichier" class="form-label">Fichier Exercice (PDF, DOCX, etc.)</label>
            <input type="file" name="fichier" class="form-control" id="fichier">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('exercices.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
