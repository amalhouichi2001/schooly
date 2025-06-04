@extends('layouts.app')

@section('content')
<style>
    .events-container {
        max-width: 900px;
        margin: auto;
        padding: 20px;
    }
    h1 {
        text-align: center;
        color: #2c3e50;
    }
    .create-button {
        display: inline-block;
        padding: 10px 15px;
        background-color: #3498db;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .event-card {
        border: 1px solid #ccc;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
    }
    .event-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .event-title {
        font-size: 20px;
        font-weight: bold;
        color: #2c3e50;
    }
    .event-date {
        font-size: 14px;
        color: #7f8c8d;
    }
    .event-description {
        margin-top: 10px;
        font-size: 16px;
        color: #34495e;
    }
    .participants {
        margin-top: 15px;
    }
    .participant {
        font-size: 14px;
        color: #2c3e50;
    }
    .btn-participer {
        padding: 8px 16px;
        background-color: #27ae60;
        border: none;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }
    .btn-participer[disabled] {
        background-color: #95a5a6;
        cursor: not-allowed;
    }
    .message {
        margin-top: 10px;
        font-size: 14px;
        color: #27ae60;
    }
    .admin-actions {
        margin-top: 15px;
        display: flex;
        gap: 10px;
    }
    .btn-edit, .btn-delete {
        padding: 6px 12px;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        color: white;
        text-decoration: none;
    }
    .btn-edit {
        background-color: #f39c12;
    }
    .btn-delete {
        background-color: #e74c3c;
    }
</style>

<div class="events-container">
    <h1>Liste des Événements</h1>

    @if(Auth::user()->isAdmin())
        <a href="{{ route('events.create') }}" class="create-button">+ Créer un événement</a>
    @endif

    @forelse($events as $event)
        <div class="event-card">
            <div class="event-header">
                <div class="event-title">{{ $event->titre }}</div>
                <div class="event-date">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</div>
            </div>

            <div class="event-description">{{ $event->description }}</div>

            @if(Auth::user()->isAdmin())
                <div class="participants">
                    <h5>Participants :</h5>
                    @if($event->participants->count() > 0)
                        <ul>
                            @foreach($event->participants as $participant)
                                <li class="participant">{{ $participant->name }} ({{ $participant->email }})</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Aucun participant pour le moment.</p>
                    @endif
                </div>

                <div class="admin-actions">
                    <a href="{{ route('events.edit', $event->id) }}" class="btn-edit">Modifier</a>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Supprimer</button>
                    </form>
                </div>
            @else
                {{-- Affichage participation --}}
                @if(!$event->participants->contains(Auth::user()->id))
                    <form action="{{ route('events.participate', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-participer">Participer</button>
                    </form>
                @else
                    <div class="message">Vous participez déjà à cet événement.</div>
                @endif
            @endif
        </div>
    @empty
        <p>Aucun événement disponible pour le moment.</p>
    @endforelse
</div>
@endsection
