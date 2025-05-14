@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-person-badge-fill"></i> Liste des enseignants</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('enseignants.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Ajouter un enseignant
    </a>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th><i class="bi bi-card-heading"></i> ID</th>
                    <th><i class="bi bi-person-circle"></i> Avatar</th>
                    <th><i class="bi bi-person"></i> Nom</th>
                    <th><i class="bi bi-person"></i> Prénom</th>
                    <th><i class="bi bi-envelope"></i> Email</th>
                    <th><i class="bi bi-phone"></i> Téléphone</th>
                    <th><i class="bi bi-book"></i> Matière</th>
                    <th><i class="bi bi-person-check"></i> Statut</th>
                    <th><i class="bi bi-tools"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($enseignants as $enseignant)
                    <tr>
                        <td>{{ $enseignant->id }}</td>
                        <td>
                            @php
                                $avatar = $enseignant->avatar ?? 'default-teacher.png';
                            @endphp
                            <img src="{{ asset('images/' . $avatar) }}" alt="Avatar" width="50" class="rounded-circle">
                        </td>
                        <td>{{ $enseignant->name }}</td>
                        <td>{{ $enseignant->prenom }}</td>
                        <td>{{ $enseignant->email }}</td>
                        <td>{{ $enseignant->telephone }}</td>
                        <td>{{ $enseignant->matiere?->nom ?? 'Non attribuée' }}</td>
                        <td>
                            @if ($enseignant->statut === 'active')
                                <span class="badge bg-success">Actif</span>
                            @elseif ($enseignant->statut === 'desactive')
                                <span class="badge bg-secondary">Inactif</span>
                            @else
                                <span class="badge bg-warning text-dark">Inconnu</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('enseignants.edit', $enseignant->id) }}" class="btn btn-sm btn-primary mb-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('enseignants.destroy', $enseignant->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Aucun enseignant trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
