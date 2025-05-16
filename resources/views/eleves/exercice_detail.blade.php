@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Détails de l'exercice</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $exercice->titre }}</h5>

            <p><strong>Description :</strong> {{ $exercice->description }}</p>

            <a href="{{ asset('storage/' . $exercice->fichier) }}" class="btn btn-outline-primary mb-3" download>
                📥 Télécharger l'exercice
            </a>

            <hr>

            <form action="{{ route('eleves.exercices.import', $exercice->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="file">Importer les réponses :</label>
                <input type="file" name="file" required>
                <button type="submit">ajouter</button>
            </form>
        </div>
    </div>
</div>
@endsection