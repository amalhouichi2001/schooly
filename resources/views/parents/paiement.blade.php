@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Paiement pour : <strong>{{ $user->name }}</strong></h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <p>Montant à payer : <strong>100.00 TND</strong></p>
    <p>Statut de l'inscription : 
        <strong>
            {{ $inscription->statut === 'payee' ? 'Payée' : 'Non payée' }}
        </strong>
    </p>

    @if ($inscription->statut === 'payee')
        {{-- ✅ Bouton pour télécharger la facture --}}
        <a href="{{ route('parents.facture', $inscription->id) }}" class="btn btn-success">
            Télécharger la facture
        </a>
    @else
        {{-- ✅ Formulaire de paiement visible seulement si non payée --}}
        <form action="{{ route('parents.paiement.payer', $inscription->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Payer maintenant</button>
        </form>
    @endif
</div>
@endsection
