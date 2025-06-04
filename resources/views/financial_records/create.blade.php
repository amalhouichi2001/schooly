@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Ajouter un enregistrement financier pour <span class="text-primary">{{ $enseignant->name }}</span></h3>

    <form action="{{ route('financial-records.store') }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf
        <input type="hidden" name="enseignant_id" value="{{ $enseignant->id }}">

        <div class="mb-3">
            <label for="montant" class="form-label">Montant (€)</label>
            <input type="number" name="montant" id="montant" step="0.01" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="revenu">Revenu</option>
                <option value="dépense">Dépense</option>
            </select>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Annuler</a>
            <button type="submit" class="btn btn-success">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
