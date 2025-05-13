@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Parents</h1>
    

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parents as $parent)
                <tr>
                    <td>{{ $parent->nom }}</td>
                    <td>{{ $parent->prenom }}</td>
                    <td>{{ $parent->email }}</td>
                    <td>{{ $parent->telephone }}</td>
                    <td>{{ $parent->adresse }}</td>
                    <td>
                        <a href="{{ route('parents.edit', $parent->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('parents.destroy', $parent->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce parent ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
