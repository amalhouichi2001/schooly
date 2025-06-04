@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Emploi du temps hebdomadaire</h2>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-light">
            <tr>
                <th>Heure</th>
                @foreach($jours as $jour)
                    <th>{{ \Carbon\Carbon::parse($jour)->locale('fr')->isoFormat('dddd') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($horaires as $heure)
                <tr>
                    <td><strong>{{ $heure }}</strong></td>
                    @foreach($jours as $jour)
                        <td>
                            @php $seance = $emploi[$heure][$jour]; @endphp
                            @if($seance)
                                <div><strong>{{ $seance->matiere->nom }}</strong></div>
                                <div>Classe : {{ $seance->classe->nom }}</div>
                                <div>Ens. : {{ $seance->enseignant->nom }}</div>
                                <div>Salle : {{ $seance->salle->nom }}</div>
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
