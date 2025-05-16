@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nouvelle inscription</h2>

    <form action="{{ route('parents.inscription.store', $eleve->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Inscrire mon enfant</button>
    </form>
</div>
@endsection
