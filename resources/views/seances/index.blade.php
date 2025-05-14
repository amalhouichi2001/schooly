@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des séances</h2>

        @if(Auth::check() && Auth::user()->is_admin)
            <a href="{{ route('seances.create') }}" class="btn btn-primary">Ajouter une séance</a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Matière</th>
                <th>Salle</th>
                <th>Type</th>
                <th>Classe</th> {{-- Ajout de la classe --}}
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seances as $seance)
            <tr>
                <td>{{ $seance->date }}</td>
                <td>{{ $seance->heure_debut }} - {{ $seance->heure_fin }}</td>
                <td>{{ $seance->matiere->nom ?? '' }}</td>
                <td>{{ $seance->salle->nom ?? '' }}</td>
                <td>{{ ucfirst($seance->type) }}</td>
                <td>{{ $seance->classe->nom ?? '' }}</td> {{-- Affiche le nom de la classe --}}
                <td>
                    

                    @if(Auth::check() && Auth::user()->is_admin)
                        <a href="{{ route('seances.edit', $seance->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('seances.destroy', $seance->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
