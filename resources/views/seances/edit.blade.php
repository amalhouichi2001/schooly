
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Modifier la séance</h2>
    <form action="{{ route('seances.update', $seance->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('seances.form')
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection