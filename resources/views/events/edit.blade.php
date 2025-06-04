@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier l'Événement</h2>

    <form action="{{ route('events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" value="{{ old('titre', $event->titre) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $event->date) }}" required>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="acces_parents" id="acces_parents" {{ $event->acces_parents ? 'checked' : '' }}>
            <label class="form-check-label" for="acces_parents">Accès parents</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="acces_enseignants" id="acces_enseignants" {{ $event->acces_enseignants ? 'checked' : '' }}>
            <label class="form-check-label" for="acces_enseignants">Accès enseignants</label>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="acces_eleves" id="acces_eleves" {{ $event->acces_eleves ? 'checked' : '' }}>
            <label class="form-check-label" for="acces_eleves">Accès élèves</label>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
