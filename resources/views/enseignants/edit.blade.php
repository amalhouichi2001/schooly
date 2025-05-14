@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-pencil-fill"></i> Modifier un enseignant</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('enseignants.update', $enseignant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" value="{{ $enseignant->name }}" required>
            </div>
            <div class="col-md-4">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" value="{{ $enseignant->prenom }}" required>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $enseignant->email }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="{{ $enseignant->telephone }}">
            </div>
            <div class="col-md-4">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" name="adresse" class="form-control" value="{{ $enseignant->adresse }}">
            </div>
            <div class="col-md-4">
                <label for="date_naissance" class="form-label">Date de naissance</label>
                <input type="date" name="date_naissance" class="form-control" value="{{ $enseignant->date_naissance }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="gender" class="form-label">Genre</label>
                <select name="gender" class="form-select">
                    <option value="male" {{ $enseignant->gender == 'male' ? 'selected' : '' }}>Homme</option>
                    <option value="female" {{ $enseignant->gender == 'female' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="matiere_id" class="form-label">Matière</label>
                <select name="matiere_id" class="form-select">
                    @foreach ($matieres as $matiere)
                        <option value="{{ $matiere->id }}" {{ $enseignant->matiere_id == $matiere->id ? 'selected' : '' }}>
                            {{ $matiere->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="statut" class="form-label">Statut</label>
                <select name="statut" class="form-select">
                    <option value="active" {{ $enseignant->statut == 'active' ? 'selected' : '' }}>Actif</option>
                    <option value="desactive" {{ $enseignant->statut == 'desactive' ? 'selected' : '' }}>Désactivé</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="profile_photo_path" class="form-label">Photo de profil</label>
                <input type="file" name="profile_photo_path" class="form-control" accept="image/*">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Modifier
        </button>
    </form>
</div>
@endsection
