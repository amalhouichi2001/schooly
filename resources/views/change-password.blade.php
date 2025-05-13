@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Changer mon mot de passe</h5>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                            <input type="password" name="current_password" id="current_password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="new_password" id="new_password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-warning">Changer le mot de passe</button>
                        <a href="{{ route('profile') }}" class="btn btn-link">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
