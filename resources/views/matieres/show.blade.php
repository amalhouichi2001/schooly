@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Enseignants de la matière : {{ $matiere->nom }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th><i class="bi bi-person-circle"></i> Avatar</th>
                    <th><i class="bi bi-person"></i> Nom</th>
                    <th><i class="bi bi-envelope"></i> Email</th>
                    <th><i class="bi bi-phone"></i> Téléphone</th>
                    <th><i class="bi bi-book"></i> Matière</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($enseignants as $enseignant)
                    <tr>
                        <td>
                            @php
                                $avatar = $enseignant->avatar ?? 'default-teacher.png';
                            @endphp
                            <img src="{{ asset('images/' . $avatar) }}" alt="Avatar" width="50" class="rounded-circle">
                        </td>
                        <td>{{ $enseignant->name }}</td>
                        <td>{{ $enseignant->email }}</td>
                        <td>{{ $enseignant->telephone }}</td>
                        <td>{{ $matiere->nom }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Aucun enseignant trouvé pour cette matière.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
