@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center text-primary">Tableau de Bord - Enseignant</h1>
    <p class="text-center">Bienvenue, <strong>{{ Auth::user()->name }}</strong> 👋</p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4">

        <!-- Mes Classes -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill fs-1 text-info"></i>
                    <h5 class="card-title mt-3">Mes Classes</h5>
                    <p class="card-text">Consulter les classes que vous enseignez.</p>
                    <a href="{{ route('classes.index') }}" class="btn btn-outline-info">Voir</a>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-pencil-square fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">Notes</h5>
                    <p class="card-text">Saisir et consulter les notes des élèves.</p>
                    <a href="{{ route('notes.index') }}" class="btn btn-outline-primary">Gérer</a>
                </div>
            </div>
        </div>

        <!-- Emploi du temps -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-event fs-1 text-success"></i>
                    <h5 class="card-title mt-3">Emploi du Temps</h5>
                    <p class="card-text">Voir votre emploi du temps de cours.</p>
                    <a href="{{ route('emploi.index') }}" class="btn btn-outline-success">Voir</a>
                </div>
            </div>
        </div>
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
        <div class="col">
        <div class="card shadow border-0 h-100">
            <div class="card-body text-center">
                <i class="bi bi-journal-text fs-1 text-success"></i>
                <h5 class="card-title mt-3">Exercices</h5>
                <p class="card-text">Voir Exercices.</p>
                <a href="{{ route('exercices.index')}}" class="btn btn-outline-success">Voir</a>
            </div>
        </div>
    </div>


    
</div>
@endsection
