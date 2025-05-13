@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow border-0">
        <div class="card-header bg-success text-white">
            <h4>Détail de l'exercice</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title text-primary">{{ $exercice->titre }}</h5>
            <p><strong>Matière :</strong> {{ $exercice->matiere }}</p>
            <p><strong>Date limite :</strong> {{ \Carbon\Carbon::parse($exercice->date_limite)->format('d/m/Y') }}</p>

            <p><strong>Description :</strong></p>
            <div class="alert alert-light">
                {!! nl2br(e($exercice->description)) !!}
            </div>

            @if($exercice->fichier)
                <p><strong>Fichier :</strong> 
                    <a href="{{ asset('storage/exercices/' . $exercice->fichier) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        📥 Télécharger
                    </a>
                </p>
            @endif

            <a href="{{ route('eleves.exercices') }}" class="btn btn-secondary mt-3">
                ⬅ Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection
