@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Liste des inscriptions</h2>

    @foreach($inscriptions as $inscription)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Élève: {{ $inscription->eleve->nom ?? 'N/A' }} {{ $inscription->eleve->prenom ?? '' }}</h5>
                <p>Date d'inscription: {{ $inscription->date_inscription->format('d/m/Y') }}</p>
                <p>Statut: {{ $inscription->statut }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection
