@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-person-plus-fill"></i> Ajouter un élève</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('eleves.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="gender" class="form-label">Sexe</label>
                <select name="gender" class="form-select" required>
                    <option value="male">Homme</option>
                    <option value="female">Femme</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="email" class="form-label">Email de l'élève</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" name="adresse" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="date_naissance" class="form-label">Date de naissance</label>
                <input type="date" name="date_naissance" class="form-control">
            </div>
            <!-- <div class="col-md-4">
                <label for="classe_id" class="form-label">Classe</label>
                <select name="classe_id" class="form-select">
                    @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                    @endforeach
                </select>
            </div> -->
            <div class="col-md-4">
                <label for="parent_id" class="form-label">Parent</label>
                <select name="parent_id" class="form-select" required>
                    @foreach($parents as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }} ({{ $parent->email }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="profile_photo_path" class="form-label">Photo de profil</label>
            <input type="file" name="profile_photo_path" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Ajouter
        </button>
    </form>
</div>
@endsection