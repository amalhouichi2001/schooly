<!-- resources/views/exercices/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails de l'exercice</h1>

        <div class="card">
            <div class="card-header">
                <h3>{{ $exercice->titre }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> {{ $exercice->description }}</p>
                <p><strong>Date limite:</strong> {{ $exercice->date_limite }}</p>
                <p><strong>Classe:</strong> {{ $exercice->classe->name }}</p>

                @if($exercice->fichier)
                    <p><strong>Fichier attaché:</strong> <a href="{{ asset('storage/' . $exercice->fichier) }}" target="_blank">Télécharger le fichier</a></p>
                @endif
            </div>
        </div>
    </div>
@endsection
