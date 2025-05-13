@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-people-fill"></i> Liste des élèves</h2>

    <a href="{{ route('eleves.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Ajouter un élève
    </a>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th><i class="bi bi-card-heading"></i> ID</th>
                    <th><i class="bi bi-person-circle"></i> Avatar</th>
                    <th><i class="bi bi-person"></i> Nom</th>
                    <th><i class="bi bi-person"></i> Prénom</th>
                    <th><i class="bi bi-gender-ambiguous"></i> Sexe</th>
                    <th><i class="bi bi-envelope"></i> Email</th>
                    <th><i class="bi bi-geo-alt"></i> Adresse</th>
                    <th><i class="bi bi-phone"></i> Téléphone</th>
                    <th><i class="bi bi-calendar-date"></i> Naissance</th>
                    <th><i class="bi bi-mortarboard"></i> Classe</th>
                    <th><i class="bi bi-tools"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eleves as $eleve)
                    <tr>
                        <td>{{ $eleve->id }}</td>
                        <td>
                            @php
                                $avatar = $eleve->gender === 'male' ? 'default-avatar-boy.png' : 'default-avatar-girl.png';
                            @endphp
                            <img src="{{ asset('images/' . $avatar) }}" alt="Avatar" width="50" class="rounded-circle">
                        </td>
                        <td>{{ $eleve->name }}</td>
                        <td>{{ $eleve->prenom }}</td>
                        <td>{{ $eleve->gender === 'male' ? 'Garçon' : 'Fille' }}</td>
                        <td>{{ $eleve->email }}</td>
                        <td>{{ $eleve->adresse }}</td>
                        <td>{{ $eleve->telephone }}</td>
                        <td>{{ \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') }}</td>
                        <td>{{ $eleve->classe?->nom ?? 'Non attribuée' }}</td>
                        <td>
                            <a href="{{ route('eleves.edit', $eleve) }}" class="btn btn-sm btn-primary mb-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('eleves.destroy', $eleve) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">
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
