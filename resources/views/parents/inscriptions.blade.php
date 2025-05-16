{{-- resources/views/parents/inscriptions.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    @if(Auth::user()->isParent())
    <a href="{{ route('eleves.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Ajouter un élève
    </a>
    @endif
    <h2>Mes Inscriptions</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom élève</th>
                <th>Date d'inscription</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscriptions as $inscription)
            <tr>
                <td>{{ $inscription->eleve->name }}</td>
                <td>{{ $inscription->date_inscription }}</td>
                <td>{{ $inscription->statut === 'payee' ? 'payée' : 'non payée' }}</td>

                <td>
                    @if($inscription->statut != 'payee')
                    <form action="{{ route('parents.paiement', $inscription->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Payer</button>
                    </form>
                    @else
                    <a href="{{ route('parents.facture.pdf', $inscription->id) }}" class="btn btn-success">Télécharger Facture</a>
                    @endif

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection