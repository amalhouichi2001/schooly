@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-pencil-square"></i> Modifier la salle</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erreurs :</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('salles.update', $salle) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la salle</label>
            <input type="text" name="nom" class="form-control" id="nom" value="{{ old('nom', $salle->nom) }}" required>
        </div>

        <div class="mb-3">
            <label for="capacite" class="form-label">Capacité</label>
            <input type="number" name="capacite" class="form-control" id="capacite" value="{{ old('capacite', $salle->capacite) }}">
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Mettre à jour
        </button>
        <a href="{{ route('salles.index') }}" class="btn btn-secondary ms-2">
            <i class="bi bi-arrow-left-circle"></i> Retour
        </a>
    </form>
</div>
@endsection
