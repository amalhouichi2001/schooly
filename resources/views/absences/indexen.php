@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Liste des élèves & Absences</h2>

    <!-- Filtrer par classe -->
    <div class="mb-4">
        <label for="classeSelect">Filtrer par classe</label>
        <select id="classeSelect" class="form-control" onchange="filterByClasse()">
            <option value="">-- Toutes les classes --</option>
            @foreach($classes as $classe)
                <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
            @endforeach
        </select>
    </div>

    <!-- Table: Élèves -->
    <h4>Liste des élèves</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Classe</th>
            </tr>
        </thead>
        <tbody id="elevesTable">
            @forelse ($eleves as $eleve)
                <tr data-classe="{{ $eleve->classe_id }}">
                    <td>{{ $eleve->nom }}</td>
                    <td>{{ $eleve->prenom }}</td>
                    <td>{{ $eleve->adresse }}</td>
                    <td>{{ $eleve->classe?->nom ?? 'Non attribuée' }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Aucun élève trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Table: Absences -->
    <h4>Historique des absences</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Élève</th>
                <th>Date</th>
                <th>Justifiée</th>
                <th>Motif</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absences as $abs)
                <tr>
                    <td>{{ $abs->eleve->nom }} {{ $abs->eleve->prenom }}</td>
                    <td>{{ $abs->date }}</td>
                    <td>{{ $abs->justifie ? 'Oui' : 'Non' }}</td>
                    <td>{{ $abs->motif }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Aucune absence enregistrée.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
function filterByClasse() {
    const selectedClasse = document.getElementById('classeSelect').value;
    const rows = document.querySelectorAll('#elevesTable tr');

    rows.forEach(row => {
        const rowClasseId = row.getAttribute('data-classe');
        if (!selectedClasse || selectedClasse === rowClasseId) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection
