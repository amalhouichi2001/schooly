@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Modifier l'enregistrement financier</h3>

    <form action="{{ route('financial-records.update', $record->id) }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="montant" class="form-label">Montant (€)</label>
            <input type="number" name="montant" id="montant" step="0.01" value="{{ $record->montant }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <small class="text-muted">{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</small>

        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="revenu" @if($record->type == 'revenu') selected @endif>Revenu</option>
                <option value="dépense" @if($record->type == 'dépense') selected @endif>Dépense</option>
            </select>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('financial-records.index') }}" class="btn btn-secondary me-2">Annuler</a>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection
