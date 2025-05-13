@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Inscription de votre enfant</h4>
                </div>

                <div class="card-body">
                <a href="{{ route('parent.inscriptions', ['eleve_id' => $eleve->id]) }}">Inscrire cet élève</a>




                        @csrf

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de l'élève</label>
                            <input type="text" class="form-control" id="nom" value="{{ $eleve->nom }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date d'inscription</label>
                            <input type="text" class="form-control" value="{{ now()->format('d/m/Y') }}" disabled>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Valider l’inscription</button>
                    </form>
                </div>
            </div>

            @if(isset($inscription))
            <div class="card mt-4 shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Paiement</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('parents.paiement', $inscription->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Montant à payer</label>
                            <input type="text" class="form-control" value="150.00 TND" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mode de paiement</label>
                            <select class="form-select" name="mode" required>
                                <option value="carte">Carte Bancaire</option>
                                <option value="espece">Espèces (à l’école)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Payer maintenant</button>
                    </form>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
