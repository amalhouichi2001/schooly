@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des séances</h2>

        @if(Auth::check() && Auth::user()->is_admin)
        <a href="{{ route('seances.create') }}" class="btn btn-primary">Ajouter une séance</a>
        @endif
    </div>
    @if(session('success') || true)
    <div class="d-flex justify-content-between align-items-center mb-3">
        @if(session('success'))
        <div class="alert alert-success mb-0 me-3 py-2 px-3">
            {{ session('success') }}
        </div>
        @endif

        <div class="d-flex align-items-center">
            <label for="typeFilter" class="me-2 mb-0 fw-bold">Filtrer par type :</label>
            <select id="typeFilter" class="form-select form-select-sm w-auto" onchange="filterSeances()">
                <option value="">Tous</option>
                <option value="cours">Cours</option>
                <option value="examen">Examen</option>
            </select>
        </div>
    </div>
    @endif


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Matière</th>
                <th>Salle</th>
                <th>Type</th>
                <th>Classe</th>
                <th>Enseignant</th> {{-- ✅ Nouvelle colonne --}}
                @if(Auth::check() && Auth::user()->is_admin)
                <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($seances as $seance)
            <tr class="seance-row" data-type="{{ $seance->type }}">
                <td>{{ $seance->date }}</td>
                <td>{{ $seance->heure_debut }} - {{ $seance->heure_fin }}</td>
                <td>{{ $seance->matiere->nom ?? '' }}</td>
                <td>{{ $seance->salle->nom ?? '' }}</td>
                <td>{{ ucfirst($seance->type) }}</td>
                <td>{{ $seance->classe->nom ?? '' }}</td>
                <td>{{ $seance->enseignant->name ?? 'N/A' }}</td> {{-- ✅ Affichage de l'enseignant --}}
                @if(Auth::check() && Auth::user()->is_admin)
                <td>
                    <a href="{{ route('seances.edit', $seance->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('seances.destroy', $seance->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>

    </table>
</div>
@endsection
<script>
    function filterSeances() {
        const selectedType = document.getElementById('typeFilter').value.toLowerCase();
        const rows = document.querySelectorAll('.seance-row');

        rows.forEach(row => {
            const rowType = row.getAttribute('data-type').toLowerCase();
            if (!selectedType || rowType === selectedType) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>