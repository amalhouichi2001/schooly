@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🛠️ Modifier l'emploi du temps</h2>

    <form action="{{ route('emploi.update', $emploi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="classe_id">Classe :</label>
            <select name="classe_id" class="form-control" required>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" {{ $emploi->classe_id == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="jour">Jour :</label>
            <select name="jour" class="form-control" required>
                @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $day)
                    <option value="{{ $day }}" {{ $emploi->jour == $day ? 'selected' : '' }}>{{ $day }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="seance">Séance :</label>
            <input type="text" name="seance" class="form-control" value="{{ $emploi->seance }}" required>
        </div>

        <div class="form-group">
            <label for="matiere">Matière :</label>
            <input type="text" name="matiere" class="form-control" value="{{ $emploi->matiere }}" required>
        </div>

        <div class="form-group">
            <label for="enseignant_id">Enseignant :</label>
            <select name="enseignant_id" class="form-control" required>
                @foreach($enseignants as $enseignant)
                    <option value="{{ $enseignant->id }}" {{ $emploi->enseignant_id == $enseignant->id ? 'selected' : '' }}>{{ $enseignant->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="heure_debut">Heure début :</label>
            <input type="time" name="heure_debut" class="form-control" value="{{ $emploi->heure_debut }}" required>
        </div>

        <div class="form-group">
            <label for="heure_fin">Heure fin :</label>
            <input type="time" name="heure_fin" class="form-control" value="{{ $emploi->heure_fin }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
        <a href="{{ route('emploi.index') }}" class="btn btn-secondary mt-3">Annuler</a>
    </form>
</div>
@endsection
