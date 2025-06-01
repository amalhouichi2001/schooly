@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Liste des inscriptions</h2>

    {{-- Si Admin : voir toutes les inscriptions --}}
    @if ($user->isAdmin())
        @foreach($inscriptions as $inscription)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Élève: {{ $inscription->eleve->name ?? 'N/A' }} {{ $inscription->eleve->prenom ?? '' }}</h5>
                    <p>Date d'inscription: {{ $inscription->date_inscription->format('d/m/Y') }}</p>
                    <p>Statut: {{ $inscription->statut }}</p>
                </div>
            </div>
        @endforeach
    @endif

    {{-- Si Parent : voir uniquement ses enfants --}}
    @if ($user->isParent())
        @foreach($inscriptions as $inscription)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Élève: {{ $inscription->eleve->name ?? 'N/A' }} {{ $inscription->eleve->prenom ?? '' }}</h5>
                    <p>Date d'inscription: {{ $inscription->date_inscription->format('d/m/Y') }}</p>
                    <p>Statut: {{ $inscription->statut }}</p>

                    {{-- Bouton de paiement --}}
                    <a href="{{ route('paiement.form', ['eleve_id' => $inscription->eleve->id]) }}" class="btn btn-success">
                        Payer
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
