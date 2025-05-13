@extends('layouts.app')

@section('title', 'Emploi du temps')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Mon emploi du temps</h2>

    @foreach ($grouped as $jour => $seances)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                {{ ucfirst($jour) }}
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Heure de début</th>
                            <th>Heure de fin</th>
                            <th>Matière</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($seances as $seance)
                            <tr>
                                <td>{{ $seance->heure_debut }}</td>
                                <td>{{ $seance->heure_fin }}</td>
                                <td>{{ $seance->matiere }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection
