@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- 🔹 Titre -->
    <h2 class="text-center text-primary mb-4">📅 Créer un Emploi du Temps</h2>

    <!-- 🔹 Formulaire de création -->
    <form action="{{ route('seances.store') }}" method="POST">
        @csrf
        <!-- Classe -->
        <div class="mb-3">
            <label class="form-label fw-bold">Choisir la classe :</label>
            <select name="classe_id" class="form-select" required>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>

        @php
            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
            $heures = ['08:00-10:00', '10:00-12:00', '13:00-15:00', '15:00-17:00'];
        @endphp

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Jour / Heure</th>
                        @foreach($heures as $heure)
                            <th>{{ $heure }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($jours as $jour)
                    <tr>
                        <th class="table-secondary">{{ $jour }}</th>
                        @foreach($heures as $heure)
                        <td>
                            <select name="emploi[{{ $jour }}][{{ $heure }}][matiere_id]" class="form-select form-select-sm mb-1">
                                <option value="">-- Matière --</option>
                                @foreach($matieres as $m)
                                    <option value="{{ $m->id }}">{{ $m->nom }}</option>
                                @endforeach
                            </select>

                            <select name="emploi[{{ $jour }}][{{ $heure }}][enseignant_id]" class="form-select form-select-sm mb-1">
                                <option value="">-- Enseignant --</option>
                                @foreach($enseignants as $e)
                                    <option value="{{ $e->id }}">{{ $e->name }}</option>
                                @endforeach
                            </select>

                            <select name="emploi[{{ $jour }}][{{ $heure }}][salle_id]" class="form-select form-select-sm">
                                <option value="">-- Salle --</option>
                                @foreach($salles as $s)
                                    <option value="{{ $s->id }}">{{ $s->nom }}</option>
                                @endforeach
                            </select>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Bouton Enregistrer -->
        <div class="text-end">
            <button type="submit" class="btn btn-success">✅ Enregistrer l'emploi du temps</button>
        </div>
    </form>

    <!-- 🔹 Bouton Voir emploi du temps -->
    <div class="text-center my-4">
        <a href="#emploi" class="btn btn-primary">👀 Voir Emploi du Temps</a>
    </div>

    <!-- 🔹 Emploi du temps existant -->
    <div id="emploi" class="py-5">
        <h2 class="text-center text-primary mb-4">📅 Emploi du Temps</h2>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Jour / Heure</th>
                        @foreach ($heures as $heure)
                            <th>{{ $heure }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jours as $jour)
                        <tr>
                            <th class="table-secondary">{{ $jour }}</th>
                            @foreach ($heures as $heure)
                                @php
                                    $seance = $emploiDuTemps->first(function ($item) use ($jour, $heure) {
                                        return $item->jour == $jour && $item->plage_horaire == $heure;
                                    });
                                @endphp
                                <td>
                                    @if($seance)
                                        <strong>{{ $seance->matiere->nom ?? 'N/A' }}</strong><br>
                                        <span>{{ $seance->salle->nom ?? '' }}</span><br>
                                        <small>{{ $seance->enseignant->name ?? '' }}</small><br><br>

                                        <!-- Modifier -->
                                        <a href="{{ route('seances.edit', $seance->id) }}" class="btn btn-sm btn-warning mb-1">✏️ Modifier</a>

                                        <!-- Supprimer -->
                                        <form action="{{ route('seances.destroy', $seance->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">🗑️ Supprimer</button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
