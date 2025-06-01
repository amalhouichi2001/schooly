@extends('layouts.app')

@section('title', 'Emploi du temps')

@section('content')
<div class="container py-4">
    <h2 class="text-center text-primary mb-4">📅 Créer un Emploi du Temps</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($user->isAdmin())
        <form action="{{ route('seances.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="classe_id" class="form-label fw-bold">Choisir la classe :</label>
                <select name="classe_id" id="classe_id" class="form-select" required>
                    <option value="" disabled selected>-- Sélectionnez une classe --</option>
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
                                    @foreach($matieres as $matiere)
                                        <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                                    @endforeach
                                </select>

                                <select name="emploi[{{ $jour }}][{{ $heure }}][enseignant_id]" class="form-select form-select-sm mb-1">
                                    <option value="">-- Enseignant --</option>
                                    @foreach($enseignants as $enseignant)
                                        <option value="{{ $enseignant->id }}">{{ $enseignant->name }}</option>
                                    @endforeach
                                </select>

                                <select name="emploi[{{ $jour }}][{{ $heure }}][salle_id]" class="form-select form-select-sm">
                                    <option value="">-- Salle --</option>
                                    @foreach($salles as $salle)
                                        <option value="{{ $salle->id }}">{{ $salle->nom }}</option>
                                    @endforeach
                                </select>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">✅ Enregistrer l'emploi du temps</button>
            </div>
        </form>
    @else
        <div class="alert alert-info text-center">
            Vous n'avez pas les droits pour modifier l'emploi du temps. Vous pouvez uniquement le consulter.
        </div>
    @endif

    <hr class="my-4">

    <h3 class="mb-3">📅 Emploi du temps enregistré</h3>

    @php
        // Organisation des séances par jour et plage horaire
        $emploiTemps = [];
        foreach ($seances as $seance) {
            $jourFr = ucfirst(Carbon\Carbon::parse($seance->date)->locale('fr')->dayName);
            $plage = $seance->heure_debut . '-' . $seance->heure_fin;
            $emploiTemps[$jourFr][$plage] = $seance;
        }
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
                            @if(isset($emploiTemps[$jour][$heure]))
                                @php $seance = $emploiTemps[$jour][$heure]; @endphp
                                <strong>{{ $seance->matiere->nom ?? 'N/A' }}</strong><br>
                                <small>Prof: {{ $seance->enseignant->name ?? 'N/A' }}</small><br>
                                <small>Salle: {{ $seance->salle->nom ?? 'N/A' }}</small>
                            @else
                                <em>—</em>
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
