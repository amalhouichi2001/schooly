@extends('layouts.app')

@section('content')
<div class="container">
    <h2><i class="bi bi-pencil"></i> Modifier la matière</h2>

    <form action="{{ route('matieres.update', $matiere) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nom de la matière</label>
            <input type="text" name="nom" class="form-control" value="{{ $matiere->nom }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('matieres.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
