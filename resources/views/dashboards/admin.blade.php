@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center text-primary">Tableau de Bord - Administrateur</h1>
    <p class="text-center">Bienvenue, <strong>{{ Auth::user()->name }}</strong> 👋</p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4">

        <!-- Élèves -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-person-badge-fill fs-1 text-success"></i>
                    <h5 class="card-title mt-3">Élèves</h5>
                    <p class="card-text">Voir, ajouter, modifier ou supprimer les élèves.</p>
                    <a href="{{ route('eleves.index') }}" class="btn btn-outline-success">Gérer</a>
                </div>
            </div>
        </div>

        <!-- Parents -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-house-heart-fill fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Parents</h5>
                    <p class="card-text">Afficher les parents associés aux élèves.</p>
                    <a href="{{ route('parents.index') }}"  class="btn btn-outline-warning">Gérer</a>
                </div>
            </div>
        </div>
         <!-- enseignants -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-house-heart-fill fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">enseignants</h5>
                    <p class="card-text">Afficher les enseignants.</p>
                    <a href="{{ route('enseignants.index') }}"  class="btn btn-outline-warning">Gérer</a>
                </div>
            </div>
        </div>
        
        <!-- Absences -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-x-fill fs-1 text-danger"></i>
                    <h5 class="card-title mt-3">Absences</h5>
                    <p class="card-text">Suivre et gérer les absences des élèves.</p>
                    <a href="{{ route('absences.index') }}" class="btn btn-outline-danger">Gérer</a>
                </div>
            </div>
        </div>

        <!-- Emploi du temps -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-event-fill fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">Emploi du Temps</h5>
                    <p class="card-text">Créer ou modifier les emplois du temps des classes.</p>
                    <a href="{{ route('emploi.index') }}" class="btn btn-outline-primary">Gérer</a>
                </div>
            </div>
        </div>

        <!-- Notes / Evaluations -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart-fill fs-1 text-secondary"></i>
                    <h5 class="card-title mt-3">Notes & Evaluations</h5>
                    <p class="card-text">Accéder aux bulletins et statistiques de notes.</p>
                    <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">Gérer</a>
                </div>
            </div>
        </div>
        <!-- classes -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart-fill fs-1 text-secondary"></i>
                    <h5 class="card-title mt-3">classes</h5>
                    <p class="card-text">classes</p>
                    <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">Gérer</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
