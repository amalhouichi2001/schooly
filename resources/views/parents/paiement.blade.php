@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Paiement pour {{ $inscription->eleve->name }}</h2>

    <form action="{{ route('parents.paiement.payer', $inscription->id) }}" method="POST">
        @csrf
        <p>Montant à payer : <strong>100.00 TND</strong></p>
        <button type="submit" class="btn btn-primary">Payer maintenant</button>
    </form>
</div>
@endsection
