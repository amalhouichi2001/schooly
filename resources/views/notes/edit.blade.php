@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ isset($note) ? 'Modifier' : 'Ajouter' }} une note</h3>

    <form method="POST" action="{{ isset($note) ? route('notes.update', $note) : route('notes.store') }}">
        @csrf
        @if(isset($note)) @method('PUT') @endif

        <div class="mb-3">
            <label>Élève</label>
            <select name="eleve_id" class="form-control">
                @foreach($eleves as $e)
                    <option value="{{ $e->id }}" {{ isset($note) && $note->eleve_id == $e->id ? 'selected' : '' }}>
                        {{ $e->nom }} {{ $e->prenom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Matière</label>
            <input name="matiere" class="form-control" value="{{ $note->matiere ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Note</label>
            <input name="note" type="number" step="0.01" class="form-control" value="{{ $note->note ?? '' }}">
        </div>

        <button class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection
