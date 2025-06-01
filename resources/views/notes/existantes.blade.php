@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Notes déjà enregistrées</h2>

    @if(isset($notesExistantes) && $notesExistantes->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Élève</th>
                    <th>Note</th>
                    <th>Enseignant</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eleves as $eleve)
                    @php
                        $note = $notesExistantes->get($eleve->id);
                    @endphp
                    @if($note)
                        <tr>
                            <td>{{ $eleve->prenom }} {{ $eleve->name }}</td>
                            <td>{{ $note->note }}</td>
                            <td>{{ $note->enseignant->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-info">Aucune note enregistrée pour cette classe et cette matière.</p>
    @endif
</div>
@endsection
