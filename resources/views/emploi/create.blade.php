<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="mb-4">Créer un emploi du temps</h2>

    <form action="{{ route('emploi.store') }}" method="POST" class="border p-4 shadow rounded bg-light">
        @csrf

        <div class="mb-3">
            <label for="classe_id" class="form-label">Classe</label>
            <select name="classe_id" id="classe_id" class="form-select" required>
                <option value="">-- Choisir une classe --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jour" class="form-label">Jour</label>
            <select name="jour" id="jour" class="form-select" required>
                <option value="">-- Choisir un jour --</option>
                <option>Lundi</option>
                <option>Mardi</option>
                <option>Mercredi</option>
                <option>Jeudi</option>
                <option>Vendredi</option>
                <option>Samedi</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="seance" class="form-label">Séance</label>
            <input type="text" name="seance" id="seance" class="form-control" placeholder="Ex: Séance 1" required>
        </div>

        <div class="mb-3">
            <label for="matiere" class="form-label">Matière</label>
            <input type="text" name="matiere" id="matiere" class="form-control" placeholder="Ex: Mathématiques" required>
        </div>

        <div class="mb-3">
            <label for="enseignant" class="form-label">Enseignant (optionnel)</label>
            <input type="text" name="enseignant" id="enseignant" class="form-control" placeholder="Ex: Mr. Ahmed">
        </div>

        <div class="mb-3">
            <label for="heure_debut" class="form-label">Heure de début</label>
            <input type="time" name="heure_debut" id="heure_debut" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="heure_fin" class="form-label">Heure de fin</label>
            <input type="time" name="heure_fin" id="heure_fin" class="form-control" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
