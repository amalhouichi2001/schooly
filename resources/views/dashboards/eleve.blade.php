@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center text-primary">Tableau de Bord - Élève</h1>
    <p class="text-center">Bienvenue, <strong>{{ Auth::user()->name }}</strong> 👋</p>
 @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4">

        <!-- Notes -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart-line-fill fs-1 text-info"></i>
                    <h5 class="card-title mt-3">Mes Notes</h5>
                    <p class="card-text">Consulter vos résultats et bulletins.</p>
                    <a href="{{ route('eleves.notes') }}" class="btn btn-outline-info">Voir</a>
                </div>
            </div>
        </div>

        <!-- Emploi du temps -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-week fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">Emploi du Temps</h5>
                    <p class="card-text">Voir votre emploi du temps.</p>
                    <a href="{{ route('emploi.index') }}" class="btn btn-outline-primary">Voir</a>
                </div>
            </div>
        </div>

        <!-- Exercices -->
        <div class="col">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-journal-text fs-1 text-success"></i>
                    <h5 class="card-title mt-3">Mes Exercices</h5>
                    <p class="card-text">Accédez aux devoirs et exercices à faire.</p>
                    <a href="{{ route('eleves.exercices') }}" class="btn btn-outline-success">Voir</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
