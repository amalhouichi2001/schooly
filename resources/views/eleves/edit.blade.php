@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier un élève</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('eleves.update', $eleve->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="mb-3 col-md-4">
                <label>Nom</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $eleve->name) }}" required>
                </div>
            </div>

            <div class="mb-3 col-md-4">
                <label>Prénom</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                    <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $eleve->prenom) }}" required>
                </div>
            </div>

            <div class="mb-3 col-md-4">
                <label>Téléphone</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $eleve->telephone) }}">
                </div>
            </div>
        </div>

        <div class="row">
           
            <div class="mb-3 col-md-4">
                <label>Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $eleve->email) }}" required>
                </div>
            </div>
            <div class="mb-3 col-md-4">
                <label>Adresse</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-house-fill"></i></span>
                    <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $eleve->adresse) }}">
                </div>
            </div>

            <div class="mb-3 col-md-4">
                <label>Date de naissance</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
                    <input type="date" name="date_naissance" class="form-control" value="{{ old('date_naissance', $eleve->date_naissance) }}" required>
                </div>
            </div>

            <div class="mb-3 col-md-4">
                <label>Sexe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                    <select name="gender" class="form-control" required>
                        <option value="male" {{ old('gender', $eleve->gender) == 'male' ? 'selected' : '' }}>Masculin</option>
                        <option value="female" {{ old('gender', $eleve->gender) == 'female' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-md-4">
                <label>Classe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-journal-bookmark-fill"></i></span>
                    <select name="classe_id" class="form-control" required>
                        @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ old('classe_id', $eleve->classe_id) == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 col-md-4">
                <label>Photo de profil</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-image-fill"></i></span>
                    <input type="file" name="profile_photo_path" class="form-control">
                </div>
                @if($eleve->profile_photo_path)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $eleve->profile_photo_path) }}" alt="Photo actuelle" width="80" class="rounded-circle">
                </div>
                @endif
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
            <i class="bi bi-check-circle-fill"></i> Mettre à jour
        </button>
    </form>
</div>
@endsection