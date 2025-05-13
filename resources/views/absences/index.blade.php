@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des élèves par classe</h2>

    <label for="classe">Sélectionner une classe</label>
    <select id="classe" class="form-control mb-3">
        <option value="">-- Choisir une classe --</option>
        @foreach($classes as $classe)
            <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
        @endforeach
    </select>

    <!-- Table: Élèves -->
    <h4>Liste des élèves</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Classe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="elevesTable">
            @forelse ($eleves as $eleve)
                <tr data-classe="{{ $eleve->classe_id }}">
                    <td>{{ $eleve->nom }}</td>
                    <td>{{ $eleve->prenom }}</td>
                    <td>{{ $eleve->adresse }}</td>
                    <td>{{ $eleve->classe?->nom ?? 'Non attribuée' }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="marquerAbsent({{ $eleve->id }})">Absent</button>
                        <button class="btn btn-primary btn-sm" onclick="justifierAbsence({{ $eleve->id }})">Justification</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Aucun élève trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    function marquerAbsent(eleveId) {
        alert("Élève ID " + eleveId + " marqué absent.");
        // Tu peux ici faire un fetch POST vers une route Laravel pour enregistrer l'absence
    }

    function justifierAbsence(eleveId) {
        let motif = prompt("Motif de l'absence pour l'élève ID " + eleveId + " :");
        if (motif) {
            alert("Justification envoyée : " + motif);
            // Tu peux ici faire un fetch POST vers une route Laravel avec le motif
        }
    }

    document.getElementById('classe').addEventListener('change', function () {
        let selectedClasse = this.value;
        let rows = document.querySelectorAll('#elevesTable tr');

        rows.forEach(row => {
            let rowClasse = row.getAttribute('data-classe');
            if (!selectedClasse || selectedClasse === rowClasse) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
