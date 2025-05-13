@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Liste des Inscriptions</h3>
    <table class="table table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>Élève</th>
                <th>Date d'inscription</th>
                <th>Validée</th>
                <th>Montant payé</th>
                <th>Statut paiement</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscriptions as $inscription)
                <tr>
                    <td>{{ $inscription->eleve->nom }}</td>
                    <td>{{ \Carbon\Carbon::parse($inscription->date)->format('d/m/Y') }}</td>
                    <td>{{ $inscription->status === 'validee' ? 'Oui' : 'Non' }}</td>
                    <td>{{ optional($inscription->paiement)->montant ?? '0.00' }}</td>
                    <td>{{ optional($inscription->paiement)->statut ?? 'Non payé' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
