@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier Parent</h1>
    <form action="{{ route('parents.update', $parent->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('parents.form', ['parent' => $parent])
        

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection



