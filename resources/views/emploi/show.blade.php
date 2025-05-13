@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Emploi du Temps de la Classe: {{ $classe->name }}</h1>

        @if($classe->emplois->isEmpty())
            <p class="text-danger">Aucun emploi du temps disponible pour cette classe.</p>
        @else
            <ul>
                @foreach($classe->emplois as $emploi)
                    <li>
                        {{ $emploi->description }} - Jour: {{ $emploi->jour }} à {{ $emploi->heure }}
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('emploi.index') }}" class="btn btn-primary mt-3">Retour à l'index</a>
    </div>
@endsection
