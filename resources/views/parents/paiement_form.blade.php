
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Formulaire de Paiement</h3>

    <form action="{{ route('parents.paiement.valider', $inscription->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="montant" class="form-label">Montant à payer</label>
            <input type="number" class="form-control" id="montant" name="montant" value="100" required>
        </div>

        <div class="mb-3">
            <label for="methode" class="form-label">Méthode de paiement</label>
            <select class="form-control" name="methode" id="methode" required>
                <option value="carte">Carte bancaire</option>
                <option value="espece">Espèces</option>
                <option value="virement">Virement bancaire</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Confirmer le paiement</button>
    </form>
</div>
@endsection
