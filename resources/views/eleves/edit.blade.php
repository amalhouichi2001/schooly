@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier un élève</h2>
    <form action="{{ route('eleves.update', $eleve) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="mb-3 col-md-4">
                <label>Nom</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $eleve->name) }}">
                </div>
            </div>

            <div class="mb-3 col-md-4">
                <label>Prénom</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                    <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $eleve->prenom) }}">
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
                    <input type="date" name="date_naissance" class="form-control" value="{{ old('date_naissance', $eleve->date_naissance) }}">
                </div>
            </div>

            <div class="mb-3 col-md-4">
                <label>Sexe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                    <select name="gender" class="form-control">
                        <option value="male" {{ $eleve->gender === 'male' ? 'selected' : '' }}>Masculin</option>
                        <option value="female" {{ $eleve->gender === 'female' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-md-4">
                <label>Classe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-journal-bookmark-fill"></i></span>
                    <select name="classe_id" class="form-control">
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ $classe->id == $eleve->classe_id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 col-md-4">
                <label>Photo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-image-fill"></i></span>
                    <input type="file" name="profile_photo_path" class="form-control">
                </div>
                @if($eleve->photo)
                    <img src="{{ asset('storage/' . $eleve->photo) }}" alt="Photo actuelle" width="80" class="mt-2 rounded-circle">
                @endif
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
            <i class="bi bi-check-circle-fill"></i> Mettre à jour
        </button>
    </form>
</div>
@endsection
