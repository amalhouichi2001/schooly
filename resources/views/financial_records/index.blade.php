@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Enregistrements financiers des enseignants</h2>
    @if($user->isAdmin())
<div class="mb-5">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">📊 Dashboard RH — Salaires du mois de {{ now()->format('F Y') }}</h5>
        </div>
        <div class="card-body">
            <p class="fs-5">Total versé aux enseignants : <strong>{{ number_format($totalMensuel, 2) }} €</strong></p>

            <form action="{{ route('financial-records.download-all') }}" method="GET" class="d-inline">
                <input type="month" name="mois" class="form-control d-inline w-auto" value="{{ now()->format('Y-m') }}">
                <button type="submit" class="btn btn-success btn-sm ms-2">⬇️ Télécharger les fiches de paie</button>
            </form>
        </div>
    </div>
</div>
@endif
@if($user->isAdmin())
<form method="GET" action="{{ route('financial-records.index') }}" class="mb-4 row g-2">
    <div class="col-md-4">
        <select name="enseignant_id" class="form-select">
            <option value="">-- Tous les enseignants --</option>
            @foreach($allEnseignants as $e)
                <option value="{{ $e->id }}" {{ request('enseignant_id') == $e->id ? 'selected' : '' }}>
                    {{ $e->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <input type="month" name="mois" class="form-control" value="{{ request('mois', now()->format('Y-m')) }}">
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary" type="submit">🔍 Filtrer</button>
    </div>
</form>
@endif


    @foreach ($enseignants as $enseignant)
        <div class="card mb-4 shadow-sm border-0">
            @if($user->isEnseignant())
                <a href="{{ route('financial-records.print', $enseignant->id) }}" class="btn btn-info btn-sm ms-2">
                    📄 Fiche de paie
                </a>
            @endif
             @if($user->isAdmin())
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $enseignant->name }}</h5>
                
                <a href="{{ route('financial-records.create', $enseignant->id) }}" class="btn btn-light btn-sm">Ajouter</a>
            </div>
            @endif
            <div class="card-body">
                @if ($enseignant->financialRecords->isEmpty())
                    <p class="text-muted">Aucun enregistrement financier.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($enseignant->financialRecords as $record)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $record->montant }} €</strong> -
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</small>

                                    <span class="badge bg-info ms-2">{{ ucfirst($record->type) }}</span>
                                </div>
                                 @if($user->isAdmin())
                                <div>
                                    <a href="{{ route('financial-records.edit', $record->id) }}" class="btn btn-sm btn-outline-primary me-1">Modifier</a>
                                    <form action="{{ route('financial-records.destroy', $record->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cet enregistrement ?')">Supprimer</button>
                                    </form>
                                </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
