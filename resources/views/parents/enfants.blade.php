@extends('layouts.app')

@section('title', 'Mes enfants')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Mes enfants</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($eleves->isEmpty())
                <p class="text-muted">Aucun enfant enregistré pour le moment.</p>
            @else
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nom complet</th>
                            <th>Classe</th>
                            <th>Date de naissance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($eleves as $enfant)
                            <tr>
                                <td>{{ $enfant->nom }} {{ $enfant->prenom }}</td>
                                <td>{{ $enfant->classe->nom ?? 'Non assignée' }}</td>
                                <td>{{ \Carbon\Carbon::parse($enfant->date_naissance)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route ('classes.bulletin', [$enfant->classe_id, $enfant->id]) }}" class="btn btn-info btn-sm">Voir</a>
                                
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

