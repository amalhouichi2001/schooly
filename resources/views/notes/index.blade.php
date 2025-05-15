@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Attribuer des notes</h2>

    <!-- Sélection Classe et Matière -->
    <form method="GET" action="{{ route('notes.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="classe_id" class="form-label">Classe :</label>
            <select name="classe_id" id="classe_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Sélectionner une classe --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" {{ $classe_id == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="matiere_id" class="form-label">Matière :</label>
           <select name="matiere_id" id="matiere_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Choisir une matière --</option>
                @foreach ($matieres as $matiere)
                    <option value="{{ $matiere->id }}" {{ $matiere_id == $matiere->id ? 'selected' : '' }}>{{ $matiere->nom }}</option>
                @endforeach
            </select>
        </div>
    </form>

    @if($classe_id && $matiere_id && $eleves->isNotEmpty())
    <!-- Formulaire de soumission des notes -->
    <form method="POST" action="{{ route('notes.store') }}">
        @csrf
        <input type="hidden" name="classe_id" value="{{ $classe_id }}">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Élève</th>
                    <th>Note à saisir</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eleves as $eleve)
                <tr>
                    <td>{{ $eleve->prenom }} {{ $eleve->name }}</td>
                    <td>
                        <input type="hidden" name="notes[{{ $loop->index }}][eleve_id]" value="{{ $eleve->id }}">
                        <input type="hidden" name="notes[{{ $loop->index }}][matiere_id]" value="{{ $matiere_id }}">
                        <input type="number" name="notes[{{ $loop->index }}][valeur]" step="0.1" min="0" max="20" class="form-control" required>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Enregistrer les notes</button>
    </form>

    <!-- Affichage des notes déjà enregistrées -->
@if(isset($notesExistantes) && $notesExistantes->isNotEmpty())
    <h3>Notes déjà enregistrées</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Élève</th>
                <th>Note</th>
                <th>Enseignant</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eleves as $eleve)
                @php
                    $note = $notesExistantes->get($eleve->id);
                @endphp
                @if($note)
                    <tr>
                        <td>{{ $eleve->prenom }} {{ $eleve->name }}</td>
                        <td>{{ $note->note }}</td>
                        <td>{{ $note->enseignant->name ?? 'N/A' }}</td>
                        <td>{{ $note->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endif

    @elseif($classe_id && $matiere_id)
        <p class="alert alert-info">Aucun élève trouvé dans cette classe.</p>
    @endif
</div>
@endsection
