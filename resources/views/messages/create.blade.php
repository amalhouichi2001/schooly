@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h5>Envoyer un message direct</h5>
    <form method="POST" action="{{ route('messages.store') }}">
        @csrf
        <div class="mb-3">
            <label for="to_id" class="form-label">Destinataire</label>
            <select name="to_id" class="form-select" required>
                <option value="" disabled selected>Choisir un utilisateur</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} {{ $u->prenom }} ({{ $u->role }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="contenu" class="form-label">Message</label>
            <textarea name="contenu" class="form-control" rows="3" placeholder="Message..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>
@endsection
