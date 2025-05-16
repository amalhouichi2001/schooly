@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-people-fill"></i> Liste des classes</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
@if(Auth::check() && Auth::user()->isAdmin())
    <a href="{{ route('classes.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Ajouter une classe
    </a>
 @endif
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Nombre d'élèves</th> <!-- Remplacé "Niveau" par nombre d'élèves -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($classes as $classe)
            <tr>
                <td>{{ $classe->id }}</td>
                <td>{{ $classe->nom }}</td>
                <td>{{ $classe->eleves->count() }}</td> <!-- Affiche le nombre d'élèves -->
                <td>
                    <a href="{{ route('classes.show', $classe) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('classes.edit', $classe) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('classes.destroy', $classe) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette classe ?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Aucune classe trouvée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection