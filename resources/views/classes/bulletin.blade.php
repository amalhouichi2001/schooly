@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Bulletin de la classe : {{ $classe->nom }}</h2>

    <a href="{{ route('classes.classes.bulletin.pdf', ['classe' => $classe, 'eleve' => $eleve]) }}" class="btn btn-outline-danger mb-4">

        <i class="bi bi-file-earmark-pdf"></i> Exporter en PDF
    </a>


    @if($moyenne !== null)
    <div class="alert alert-primary text-center">
        <strong>Moyenne générale :</strong> {{ $moyenne }}/20
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <strong>{{ $eleve->name }}</strong> ({{ $eleve->email }})
        </div>
        <div class="card-body">
            @if($notes->isNotEmpty())
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Matière</th>
                        <th>Enseignant</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notes as $note)
                    <tr>
                        <td>{{ $note->matiere->nom ?? 'N/A' }}</td>
                        <td>{{ $note->enseignant->name ?? 'N/A' }}</td>
                        <td>{{ $note->note }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="alert alert-warning text-center">
                Aucune note disponible pour cet élève.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection