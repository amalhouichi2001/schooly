@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-people-fill"></i> Liste des Parents</h2>

    {{-- Bouton pour créer un nouveau parent --}}
    <a href="{{ route('parents.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Ajouter un parent
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th><i class="bi bi-card-heading"></i> ID</th>
                    <th><i class="bi bi-person"></i> Nom</th>
                    <th><i class="bi bi-person"></i> Prénom</th>
                    <th><i class="bi bi-envelope"></i> Email</th>
                    <th><i class="bi bi-phone"></i> Téléphone</th>
                    <th><i class="bi bi-geo-alt"></i> Adresse</th>
                    <th><i class="bi bi-tools"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($parents as $parent)
                    <tr>
                        <td>{{ $parent->id }}</td>
                        <td>{{ $parent->name }}</td>
                        <td>{{ $parent->prenom }}</td>
                        <td>{{ $parent->email }}</td>
                        <td>{{ $parent->telephone }}</td>
                        <td>{{ $parent->adresse }}</td>
                        <td>
                            <a href="{{ route('parents.edit', $parent->id) }}" class="btn btn-sm btn-primary mb-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('parents.destroy', $parent->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce parent ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
