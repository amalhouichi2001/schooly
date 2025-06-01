@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <h1>Inscription Parent</h1>
    <form action="{{ route('parents.store') }}" method="POST">
        @csrf
        @include('parents.form') {{-- Contient nom, prénom, email, etc. --}}
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>
@endsection
