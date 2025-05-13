<!-- enfants.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Mes Enfants</h2>
        @foreach($eleve as $eleve)
            <p>{{ $eleve->nom }}</p>
        @endforeach
    </div>
@endsection
