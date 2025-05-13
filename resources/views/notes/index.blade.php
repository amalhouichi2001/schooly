@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestion des notes</h2>

    <!-- Formulaire de sélection de la classe -->
    <form method="GET" action="{{ route('notes.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <label for="classe_id">Choisir une classe :</label>
                <select name="classe_id" id="classe_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Sélectionner une classe --</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <!-- Formulaire d'enregistrement des notes -->
    <form method="POST" action="{{ route('notes.store') }}">
        @csrf
        <input type="hidden" name="classe_id" value="{{ $classe_id }}">
        <input type="hidden" name="enseignant_id" value="{{ Auth::id() }}">

        <div class="form-group">
            @foreach ($eleves as $eleve)
                <div class="mb-3">
                    <label for="eleve_{{ $eleve->id }}">{{ $eleve->nom }}</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="eleve_{{ $eleve->id }}" name="notes[{{ $eleve->id }}][valeur]" required step="0.01" placeholder="Note de {{ $eleve->nom }}">
                        <input type="text" class="form-control" name="notes[{{ $eleve->id }}][matiere]" required placeholder="Matière">
                        
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>

    <!-- Affichage des notes déjà enregistrées -->
    @if($notes->isNotEmpty())
        <h3 class="mt-5">Notes déjà enregistrées</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom de l'élève</th>
                    <th>Matière</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notes as $note)
                    <tr>
                        <td>{{ $note->eleve->nom }}</td>
                        <td>{{ $note->matiere }}</td>
                        <td>{{ $note->valeur }}</td>
                        <td>
                            <!-- Lien vers la page show de la note -->
                            <a href="{{ route('notes.show', $note->id) }}" class="btn btn-info btn-sm">Voir</a>
                            <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-info">Aucune note enregistrée pour cette classe.</p>
    @endif
</div>
@endsection
