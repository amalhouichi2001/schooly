@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la classe</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('classes.update', $classe->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="nom">Niveau</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $classe->nom) }}" required>
        </div>

       

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('classes.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
