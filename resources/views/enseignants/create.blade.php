@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-person-plus-fill"></i> Ajouter un enseignant</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('enseignants.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="role" value="enseignant">

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" name="adresse" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="date_naissance" class="form-label">Date de naissance</label>
                <input type="date" name="date_naissance" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="gender" class="form-label">Genre</label>
                <select name="gender" class="form-select">
                    <option value="male">Homme</option>
                    <option value="female">Femme</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="matiere_id" class="form-label">Matière</label>
                <select name="matiere_id" class="form-select">
                    @foreach ($matieres as $matiere)
                        <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="statut" class="form-label">Statut</label>
                <select name="statut" class="form-select">
                    <option value="active">Actif</option>
                    <option value="desactive">Désactivé</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="password_confirmation" class="form-label">Confirmation</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="profile_photo_path" class="form-label">Photo de profil</label>
                <input type="file" name="profile_photo_path" class="form-control" accept="image/*">
            </div>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Ajouter
        </button>
    </form>
</div>
@endsection
