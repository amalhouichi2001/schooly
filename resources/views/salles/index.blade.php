@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-building"></i> Liste des salles</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('salles.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Ajouter une salle
    </a>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Capacité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($salles as $salle)
                <tr>
                    <td>{{ $salle->id }}</td>
                    <td>{{ $salle->nom }}</td>
                    <td>{{ $salle->capacite ?? '—' }}</td>
                    <td>
                        <a href="{{ route('salles.edit', $salle) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('salles.destroy', $salle) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette salle ?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Aucune salle trouvée.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
