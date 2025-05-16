@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Détails de {{ $eleve->nom }} {{ $eleve->prenom }}</h3>

    <p><strong>Date de naissance :</strong> {{ $eleve->date_naissance }}</p>
    <p><strong>Classe :</strong> {{ $classe->nom ?? 'Non assignée' }}</p>

    <h5>Bulletin :</h5>
    @if($bulletin)
    <ul>
        <li>Moyenne : {{ $bulletin->moyenne }}</li>
        <li>Remarques : {{ $bulletin->remarques }}</li>
    </ul>
    @else
    <p>Aucun bulletin disponible.</p>
    @endif

    @if(auth()->user()->hasRole('parent'))
    <form action="{{ route('parents.inscription', $eleve->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Inscrire l'élève</button>
    </form>
    @endif

    <a href="{{ route('parents.enfants', $eleve->parent_id) }}" class="btn btn-secondary mt-2">Retour</a>
</div>
@endsection