@extends('layouts.app') {{-- ou ton layout --}}

@section('content')
<div class="container">

    <a href="{{ route('parents.inscription.form') }}" class="btn btn-success mb-3">+ Nouvelle inscription</a>

    <table class="table table-striped">
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
                    <td>{{ \Carbon\Carbon::parse($inscription->date_inscription)->format('d/m/Y') }}</td>
                    <td>{{ $inscription->validee ? 'Oui' : 'Non' }}</td>
                    <td>{{ optional($inscription->paiement)->montant ?? '0.00' }}</td>
                    <td>{{ optional($inscription->paiement)->statut ?? 'Non payé' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
<form action="{{ route('parents.inscription.store') }}" method="POST">
    @csrf
    <select name="eleve_id" class="form-control">
        @foreach($eleves as $eleve)
            <option value="{{ $eleve->id }}">{{ $eleve->nom }}</option>
        @endforeach
    </select>
    <input type="date" name="date_inscription" class="form-control mt-2">
    <button type="submit" class="btn btn-primary mt-2">Inscrire</button>
</form>

@endsection
