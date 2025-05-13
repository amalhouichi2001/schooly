@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nouvelle inscription</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inscription.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="date_naissance">Date de naissance :</label>
            <input type="date" name="date_naissance" class="form-control" value="{{ old('date_naissance') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="adresse">Adresse :</label>
            <input type="text" name="adresse" class="form-control" value="{{ old('adresse') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="classe_id">Classe :</label>
            <select name="classe_id" class="form-control" required>
                <option value="">-- Sélectionner une classe --</option>
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Si l'utilisateur connecté est celui qu'on enregistre, on peut auto-remplir user_id --}}
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        <button type="submit" class="btn btn-primary">Inscrire</button>
    </form>
</div>
@endsection
