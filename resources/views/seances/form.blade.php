<div class="mb-3">
    <label for="emploi_class_id" class="form-label">Classe</label>
    <select name="emploi_class_id" class="form-control">
        <option value="">-- Aucune --</option>
        @foreach($classes as $classe)
            <option value="{{ $classe->id }}" {{ old('emploi_class_id', $seance->emploi_class_id ?? '') == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="emploi_enseignant_id" class="form-label">Enseignant</label>
    <select name="emploi_enseignant_id" class="form-control">
        <option value="">-- Aucun --</option>
        @foreach($enseignants as $enseignant)
            <option value="{{ $enseignant->id }}" {{ old('emploi_enseignant_id', $seance->emploi_enseignant_id ?? '') == $enseignant->id ? 'selected' : '' }}>{{ $enseignant->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Date</label>
    <input type="date" name="date" class="form-control" value="{{ old('date', $seance->date ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">Heure début</label>
    <input type="time" name="heure_debut" class="form-control" value="{{ old('heure_debut', $seance->heure_debut ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">Heure fin</label>
    <input type="time" name="heure_fin" class="form-control" value="{{ old('heure_fin', $seance->heure_fin ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">Durée (minutes)</label>
    <input type="number" name="duration" class="form-control" value="{{ old('duration', $seance->duration ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">Matière</label>
    <select name="matiere_id" class="form-control">
        @foreach($matieres as $matiere)
            <option value="{{ $matiere->id }}" {{ old('matiere_id', $seance->matiere_id ?? '') == $matiere->id ? 'selected' : '' }}>{{ $matiere->nom }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Salle</label>
    <select name="salle_id" class="form-control">
        @foreach($salles as $salle)
            <option value="{{ $salle->id }}" {{ old('salle_id', $seance->salle_id ?? '') == $salle->id ? 'selected' : '' }}>{{ $salle->nom }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Type</label>
    <select name="type" class="form-control">
        <option value="cours" {{ old('type', $seance->type ?? '') == 'cours' ? 'selected' : '' }}>Cours</option>
        <option value="examen" {{ old('type', $seance->type ?? '') == 'examen' ? 'selected' : '' }}>Examen</option>
    </select>
</div>
