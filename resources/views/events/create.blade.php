@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Créer un événement</h2>

    <form action="{{ route('events.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Accès autorisé :</label><br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="acces_parents" value="1" id="acces_parents">
                <label class="form-check-label" for="acces_parents">Parents</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="acces_enseignants" value="1" id="acces_enseignants">
                <label class="form-check-label" for="acces_enseignants">Enseignants</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="acces_eleves" value="1" id="acces_eleves">
                <label class="form-check-label" for="acces_eleves">Élèves</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
