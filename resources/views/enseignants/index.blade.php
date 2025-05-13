@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des Enseignants</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('enseignants.create') }}" class="btn btn-primary mb-3">+ Ajouter Enseignant</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Spécialité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enseignants as $enseignant)
                <tr>
                    <td>{{ $enseignant->nom }}</td>
                    <td>{{ $enseignant->prenom }}</td>
                    <td>{{ $enseignant->email }}</td>
                    <td>{{ $enseignant->specialite }}</td>
                    <td>
                        <a href="{{ route('enseignants.edit', $enseignant->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
