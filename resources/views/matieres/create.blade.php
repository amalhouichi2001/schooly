@extends('layouts.app')

@section('content')
<div class="container">
    <h2><i class="bi bi-plus-circle"></i> Ajouter une matière</h2>

    <form action="{{ route('matieres.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nom de la matière</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('matieres.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
