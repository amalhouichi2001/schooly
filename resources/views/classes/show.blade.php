@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">
        <i class="bi bi-house-fill"></i> Détails de la classe : {{ $classe->nom }}
    </h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <p><strong>ID :</strong> {{ $classe->id }}</p>
        <p><strong>Nom :</strong> {{ $classe->nom }}</p>
        <a href="{{ route('classes.edit', $classe) }}" class="btn btn-outline-primary">
            <i class="bi bi-pencil-square"></i> Modifier la classe
        </a>

    </div>

    <hr>

    {{-- Liste des élèves dans cette classe --}}
    <h4><i class="bi bi-people-fill"></i> Élèves dans la classe</h4>
    <ul class="list-group mb-3">
        @forelse ($elevesDansClasse as $eleve)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $eleve->name }}</strong> ({{ $eleve->email }})
                @if ($eleve->moyenne !== null)
                <div class="text-muted small">Moyenne : {{ $eleve->moyenne }}/20 | Rang : {{ $eleve->rang }}</div>
                @else
                <div class="text-muted small">Aucune note</div>
                @endif
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('classes.bulletin', [$classe->id, $eleve->id]) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-journal-text"></i>
                </a>
                <form method="POST" action="{{ route('classes.retirerEleve', [$classe, $eleve]) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Retirer cet élève ?')">
                        <i class="bi bi-x-circle"></i> Retirer
                    </button>
                </form>
            </div>
        </li>
        @empty
        <li class="list-group-item text-muted">Aucun élève dans cette classe.</li>
        @endforelse
    </ul>


    {{-- Ajouter un élève à cette classe --}}
    <h4><i class="bi bi-person-plus-fill"></i> Ajouter un élève sans classe</h4>
    @if ($elevesSansClasse->count())
    <form method="POST" action="{{ route('classes.ajouterEleve', $classe) }}">
        @csrf
        <div class="input-group mb-3">
            <select name="eleve_id" class="form-select" required>
                <option value="">-- Sélectionner un élève --</option>
                @foreach ($elevesSansClasse as $eleve)
                <option value="{{ $eleve->id }}">{{ $eleve->name }} ({{ $eleve->email }})</option>
                @endforeach
            </select>
            <button class="btn btn-success" type="submit">
                <i class="bi bi-check-circle-fill"></i> Ajouter
            </button>
        </div>
    </form>
    @else
    <p class="text-muted">Aucun élève disponible à ajouter.</p>
    @endif

</div>
@endsection