@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Créer un emploi du temps</h2>

    <form action="{{ route('seances.store') }}" method="POST">
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

        <h4>Planning hebdomadaire</h4>

        @php
            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
            $plages = ['08:00-09:00', '09:00-10:00', '10:15-11:15', '11:15-12:15', '14:00-15:00', '15:00-16:00'];
        @endphp

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Heure</th>
                    @foreach($jours as $jour)
                        <th>{{ $jour }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($plages as $plage)
                <tr>
                    <td>{{ $plage }}</td>
                    @foreach($jours as $jour)
                    <td>
                        <select name="emploi[{{ $jour }}][{{ $plage }}][matiere_id]" class="form-select mb-1" required>
                            <option value="">Matière</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                            @endforeach
                        </select>

                        <select name="emploi[{{ $jour }}][{{ $plage }}][enseignant_id]" class="form-select mb-1" required>
                            <option value="">Enseignant</option>
                            @foreach($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}">{{ $enseignant->name }}</option>
                            @endforeach
                        </select>

                        <select name="emploi[{{ $jour }}][{{ $plage }}][salle_id]" class="form-select" required>
                            <option value="">Salle</option>
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

        <button type="submit" class="btn btn-primary">Enregistrer l'emploi du temps</button>
    </form>
</div>
@endsection
