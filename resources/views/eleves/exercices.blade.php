@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center text-success">📚 Mes Exercices</h2>

    @if($exercices->isEmpty())
        <div class="alert alert-info text-center">
            Aucun exercice disponible pour le moment.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover shadow-sm">
                <thead class="table-success text-center">
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Matière</th>
                        <th>Date limite</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exercices as $index => $exercice)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $exercice->titre }}</td>
                            <td>{{ $exercice->matiere }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($exercice->date_limite)->format('d/m/Y') }}</td>

                            <td class="text-center">
                                <a href="{{ route('eleves.exercice.show', $exercice->id) }}" class="btn btn-sm btn-outline-success">
                                    Consulter
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
