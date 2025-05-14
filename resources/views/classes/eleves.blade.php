@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Élèves de la classe : {{ $classe->nom }}</h2>

    @if($eleves->isEmpty())
        <div class="alert alert-info">Aucun élève inscrit dans cette classe.</div>
    @else
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eleves as $eleve)
                    <tr>
                        <td>{{ $eleve->name }}</td>
                        <td>{{ $eleve->prenom }}</td>
                        <td>{{ $eleve->email }}</td>
                        <td>{{ $eleve->telephone }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('classes.index') }}" class="btn btn-secondary mt-3">Retour à la liste des classes</a>
</div>
@endsection
