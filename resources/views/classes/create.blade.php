@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-plus-circle"></i> Ajouter une classe</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erreurs :</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('classes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la classe</label>
            <input type="text" name="nom" class="form-control" id="nom" value="{{ old('nom') }}" required>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Enregistrer
        </button>
        <a href="{{ route('classes.index') }}" class="btn btn-secondary ms-2">
            <i class="bi bi-arrow-left-circle"></i> Retour
        </a>
    </form>
</div>
@endsection
