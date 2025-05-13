@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Mon Espace</h5>
                </div>

                <div class="card-body">
                    <p><strong>Nom :</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Date d'inscription :</strong> {{ Auth::user()->created_at->format('d/m/Y') }}</p>

                    <hr>

                    <a href="{{ route('edit.profile') }}" class="btn btn-outline-primary">
                        Modifier mes informations
                    </a>
                    <a href="{{ route('password.form') }}" class="btn btn-outline-warning mt-3">
                        Changer mon mot de passe
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
