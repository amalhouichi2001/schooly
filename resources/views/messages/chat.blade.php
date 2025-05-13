@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Conversation avec {{ $user->name }}</h4>

    <div class="mb-3" style="height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
        @foreach($messages as $message)
            <div class="{{ $message->from_id == auth()->id() ? 'text-end' : 'text-start' }}">
                <p>
                    <strong>{{ $message->from_id == auth()->id() ? 'Moi' : $user->name }}:</strong>
                    {{ $message->contenu }}
                    <br>
                    <small class="text-muted">{{ $message->created_at->format('d/m/Y H:i') }}</small>
                </p>
            </div>
        @endforeach
    </div>

    <form action="{{ route('messages.store', $user->id) }}" method="POST">
        @csrf
        <div class="input-group">
            <input type="text" name="contenu" class="form-control" placeholder="Écrire un message...">
            <button class="btn btn-primary" type="submit">Envoyer</button>
        </div>
    </form>
</div>
@endsection
