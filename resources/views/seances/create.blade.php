@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Ajouter une nouvelle séance</h2>
    <form action="{{ route('seances.store') }}" method="POST">
        @csrf
        @include('seances.form')
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection


