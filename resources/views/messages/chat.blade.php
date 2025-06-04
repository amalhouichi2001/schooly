@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-4 border-end" style="height: 80vh; overflow-y: auto;">
            <h5 class="mt-3">Mes conversations</h5>
            <ul class="list-group list-group-flush">
                @foreach($users as $u)
                    <li class="list-group-item {{ $u->id == $user->id ? 'active' : '' }}">
                        <a href="{{ route('messages.show', $u->id) }}" class="text-decoration-none {{ $u->id == $user->id ? 'text-white' : 'text-dark' }}">
                            {{ $u->name }} {{ $u->prenom }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Chatbox -->
        <div class="col-md-8 d-flex flex-column" style="height: 80vh;">
            <div class="py-3 border-bottom">
                <h5>Conversation avec {{ $user->name }} {{ $user->prenom }}</h5>
            </div>

            <div class="flex-grow-1 overflow-auto px-3 py-2" style="background-color: #f8f9fa;">
                @forelse($messages as $message)
                    <div class="mb-2 {{ $message->sender_id == auth()->id() ? 'text-end' : 'text-start' }}">
                        <div class="d-inline-block px-3 py-2 rounded 
                            {{ $message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light' }}">
                            <strong>{{ $message->sender_id == auth()->id() ? 'Moi' : $user->name }}:</strong><br>
                            {{ $message->content }}
                        </div>
                    </div>
                @empty
                    <p class="text-center mt-3">Aucun message.</p>
                @endforelse
            </div>

            <!-- Formulaire d'envoi de message -->
            <form action="{{ route('messages.store', $user->id) }}" method="POST" class="border-top p-3">
                @csrf
                <div class="input-group">
                    <input type="text" name="contenu" class="form-control" placeholder="Écrivez un message..." required>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
                @error('contenu')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </form>
        </div>
    </div>
</div>
@endsection
