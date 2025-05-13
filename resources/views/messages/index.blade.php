@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Mes conversations</h4>
    <ul class="list-group">
        @foreach($users as $user)
            <li class="list-group-item">
                <a href="{{ route('messages.show', $user->id) }}">{{ $user->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
