@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center text-primary mb-4">Mes Notes</h2>

    @if($notes->isEmpty())
        <div class="alert alert-info text-center">
            Aucune note disponible pour le moment.
        </div>
    @else
        <div class="mb-4 text-center">
            <h4 class="text-success">
                📊 Moyenne Générale : 
                <span class="badge bg-success">{{ number_format($moyenne, 2) }}/20</span>
            </h4>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($notes as $note)
            <div class="col">
                <div class="card shadow h-100 border-info">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $note->matiere->nom ?? 'Matière inconnue' }}</h5>
                        <p class="card-text">
                            <strong>Classe :</strong> {{ $note->classe->nom ?? 'N/A' }} <br>
                            <strong>Note :</strong> 
                            <span class="fs-4 text-{{ $note->valeur >= 10 ? 'success' : 'danger' }}">
                                {{ $note->valeur }}/20
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
