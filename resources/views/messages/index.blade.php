@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-4 border-end" style="height: 80vh; overflow-y: auto;">
            <h5 class="mt-3">Mes conversations</h5>
            <ul class="list-group list-group-flush">
                @foreach($users as $user)
                    <li class="list-group-item">
                        <a href="{{ route('messages.show', $user->id) }}" class="text-decoration-none d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $user->name }} {{ $user->prenom }}</strong>
                                <br>
                                <small class="text-muted">{{ $user->role ?? '' }}</small>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Default placeholder -->
        <div class="col-md-8 d-flex align-items-center justify-content-center text-muted">
            <p>Sélectionnez une conversation pour commencer.</p>
        </div>
    </div>
</div>
@endsection
