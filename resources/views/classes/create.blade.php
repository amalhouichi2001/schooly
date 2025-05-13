@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une classe</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('classes.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="nom">Niveau la classe</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
        </div>

        

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('classes.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
