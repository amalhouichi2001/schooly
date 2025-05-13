@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Liste des Exercices</h2>

    {{-- Bouton pour créer un nouvel exercice --}}
    <a href="{{ route('exercices.create') }}" class="btn btn-primary mb-3">+ Ajouter un Exercice</a>

    {{-- Affichage des messages de session --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tableau des exercices --}}
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Titre</th>
                <th>Classe</th>
                <th>Date Limite</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($exercices as $ex)
                <tr>
                    <td>{{ $ex->titre }}</td>
                    <td>{{ $ex->classe->nom ?? 'Non défini' }}</td>
                    <td>{{ $ex->date_limite }}</td>
                    <td>
                        <a href="{{ route('exercices.show', $ex->id) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('exercices.edit', $ex->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('exercices.destroy', $ex->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet exercice ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun exercice trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
