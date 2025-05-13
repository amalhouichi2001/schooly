@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Modifier mon profil</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('update.profile') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $user->name) }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Enregistrer</button>
                        <a href="{{ route('profile') }}" class="btn btn-link">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
