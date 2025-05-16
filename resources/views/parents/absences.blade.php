@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des absences de vos enfants</h2>

    @if ($absences->isEmpty())
        <p>Aucune absence enregistrée.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom de l'élève</th>
                    <th>Date</th>
                    <th>Motif</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absences as $absence)
                    <tr>
                        <td>{{ $absence->eleve->name }}</td>
                        <td>{{ $absence->date }}</td>
                        <td>{{ $absence->motif }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
