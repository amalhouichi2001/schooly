@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inscription Parent</h1>
    <form action="{{ route('parents.inscription.store') }}" method="POST">
        @csrf
        @include('parents.form') {{-- Contient nom, prénom, email, etc. --}}
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>
@endsection
