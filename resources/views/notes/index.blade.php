@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des élèves</h2>

    <!-- Formulaire de sélection de la classe -->
    <form method="GET" action="{{ route('notes.index') }}" class="mb-4">
        <div class="form-group">
            <label for="classe_id">Choisir une classe :</label>
            <select name="classe_id" id="classe_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Sélectionner une classe --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" {{ $classe_id == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Liste des élèves -->
    @if($classe_id && $eleves->isNotEmpty())
        <ul class="list-group mt-3">
            @foreach($eleves as $eleve)
                <li class="list-group-item">{{ $eleve->nom }}</li>
            @endforeach
        </ul>
    @elseif($classe_id)
        <p class="alert alert-info mt-3">Aucun élève trouvé pour cette classe.</p>
    @endif
</div>
@endsection
