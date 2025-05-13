@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Gestion des Emplois du Temps</h2>

    <div class="mb-3">
        <a href="{{ route('emploi.create') }}" class="btn btn-primary">➕ Ajouter un emploi</a>
    </div>

    <!-- Sélectionner la classe -->
    <div class="form-group mb-4">
        <label for="classeSelect">Sélectionner une classe :</label>
        <form method="GET" action="{{ route('emploi.index') }}">
            <select class="form-control" name="classe_id" onchange="this.form.submit()">
                <option value="">-- Choisir une classe --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" @if(request('classe_id') == $classe->id) selected @endif>{{ $classe->nom }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Affichage des emplois du temps si des emplois sont trouvés -->
    @if(isset($emplois) && count($emplois) > 0)
        <h4>Emploi du temps :</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Séance</th>
                    <th>Matière</th>
                    <th>Professeur</th>
                    <th>Heure début</th>
                    <th>Heure fin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emplois as $emploi)
                    <tr>
                        <td>{{ $emploi->jour }}</td>
                        <td>{{ $emploi->seance }}</td>
                        <td>{{ $emploi->matiere }}</td>
                        <td>{{ $emploi->enseignant }}</td>
                        <td>{{ $emploi->heure_debut }}</td>
                        <td>{{ $emploi->heure_fin }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif(request('classe_id'))
        <p>Aucun emploi du temps trouvé pour la classe sélectionnée.</p>
    @endif
</div>
@endsection
