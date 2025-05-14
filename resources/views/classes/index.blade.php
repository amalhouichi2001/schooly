@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des classes</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
@if(auth()->user()->role === 'admin')
    <a href="{{ route('classes.create') }}" class="btn btn-primary mb-3">Ajouter une classe</a>
@endif


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Niveau</th>
               
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $classe)
                <tr>
                    <td>{{ $classe->id }}</td>
                    <td>{{ $classe->nom }}</td>
                    <td>
                    <a href="{{ route('classes.eleves', $classe->id) }}">voir</a>


                    @if(auth()->user()->role === 'admin')
                       
                            <a href="{{ route('classes.edit', $classe->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <form action="{{ route('classes.destroy', $classe->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette classe ?')">Supprimer</button>
                            </form>
                        </td>
                     @endif

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
