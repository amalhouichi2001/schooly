@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Saisie des notes</h2>

    {{-- Messages de succès ou d'erreur --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($eleves->isEmpty())
        <div class="alert alert-warning">Aucun élève trouvé pour cette classe.</div>
    @else
        <form action="{{ route('notes.store') }}" method="POST">
            @csrf

            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nom de l'élève</th>
                        <th>Note (sur 20)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eleves as $eleve)
                        <tr>
                            <td>{{ $eleve->prenom }} {{ $eleve->name }}</td>
                            <td style="width: 200px;">
                                <input type="hidden" name="notes[{{ $loop->index }}][eleve_id]" value="{{ $eleve->id }}">
                                <input type="hidden" name="notes[{{ $loop->index }}][matiere_id]" value="{{ $matiere_id }}">
                                <input type="number" name="notes[{{ $loop->index }}][valeur]" 
                                       class="form-control text-center" 
                                       step="0.1" min="0" max="20" required>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <a href="{{ route('notes.existantes', ['classe_id' => $classe_id, 'matiere_id' => $matiere_id]) }}" class="btn btn-outline-secondary">
                    Voir les notes enregistrées
                </a>
                <button type="submit" class="btn btn-primary">
                    Enregistrer les notes
                </button>
            </div>
        </form>
    @endif

</div>
@endsection
