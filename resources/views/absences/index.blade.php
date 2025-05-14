@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Liste des élèves & Absences</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
                @if(Auth::user()->role === 'enseignant')
                    <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody id="elevesTable">
            @forelse ($eleves as $eleve)
                <tr data-classe="{{ $eleve->classe_id }}">
                    <td>{{ $eleve->nom }}</td>
                    <td>{{ $eleve->prenom }}</td>
                    <td>{{ $eleve->adresse }}</td>
                    <td>{{ $eleve->classe?->nom ?? 'Non attribuée' }}</td>
                    @if(Auth::user()->role === 'enseignant')
                        <td>
                            <form method="POST" action="{{ route('absences.marquer') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="eleve_id" value="{{ $eleve->id }}">

                                <!-- Sélectionner une séance -->
                                <select name="seance_id" class="form-control">
                                    @foreach($seances as $seance)
                                        <option value="{{ $seance->id }}" {{ old('seance_id') == $seance->id ? 'selected' : '' }}>
                                            {{ $seance->nom }} ({{ $seance->date }} {{ $seance->heure_debut }})
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn-danger btn-sm mt-2">Marquer comme Absent</button>
                            </form>
                        </td>
                    @endif
                    @if(Auth::user()->role === 'admin')
                        <td>
                            <!-- Formulaire pour l'administrateur pour ajouter un motif -->
                            <form method="POST" action="{{ route('absences.justification') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="eleve_id" value="{{ $eleve->id }}">
                                <select name="absence_id" class="form-control">
                                    @foreach($absences as $absence)
                                        @if($absence->eleve_id == $eleve->id)
                                            <option value="{{ $absence->id }}" {{ old('absence_id') == $absence->id ? 'selected' : '' }}>
                                                Absence du {{ $absence->date }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                                <input type="text" name="motif" class="form-control mt-2" placeholder="Motif de l'absence" required>
                                <button type="submit" class="btn btn-success btn-sm mt-2">Ajouter la Justification</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr><td colspan="5">Aucun élève trouvé.</td></tr>
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
                    <td>{{ $abs->motif ?? 'Non renseigné' }}</td>
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
