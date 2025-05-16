@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center text-primary mb-4">🗓️ Mon Emploi du Temps</h2>

    @if($emploiDuTemps->isEmpty())
        <div class="alert alert-warning text-center">Aucun emploi du temps disponible.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Jour</th>
                        <th>Heure Début</th>
                        <th>Heure Fin</th>
                        <th>Matière</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emploiDuTemps as $cours)
                    <tr>
                        <td>{{ $cours->date }}</td>
                        <td>{{ $cours->heure_debut }}</td>
                        <td>{{ $cours->heure_fin }}</td>
                        <td>{{ $cours->matiere->nom }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
