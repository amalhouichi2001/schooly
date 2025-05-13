@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center text-primary">Tableau de Bord - Parent</h1>
    <p class="text-center">Bienvenue, <strong>{{ Auth::user()->name }}</strong> 👋</p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4">

        <!-- Enfants -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-person-lines-fill fs-1 text-success"></i>
                    <h5 class="card-title mt-3">Mes Enfants</h5>
                    <p class="card-text">Voir les informations et bulletins de vos enfants.</p>
                    <a href="{{ route('parents.enfants') }}" class="btn btn-outline-success">Voir</a>
                </div>
            </div>
        </div>

        <!-- Absences -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-x fs-1 text-danger"></i>
                    <h5 class="card-title mt-3">Absences</h5>
                    <p class="card-text">Consulter les absences signalées de vos enfants.</p>
                    <a href="{{ route('parents.absences') }}" class="btn btn-outline-danger">Voir</a>
                </div>
            </div>
        </div>

        <!-- Inscriptions & Paiement -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-cash-coin fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">Inscriptions & Paiement</h5>
                    <p class="card-text">Inscrire vos enfants et régler les frais d’inscription.</p>
                    <a href="{{ route('parent.inscription.form') }}" class="btn btn-outline-primary">Accéder</a>



                </div>
            </div>
        </div>

    </div>
</div>
@endsection
