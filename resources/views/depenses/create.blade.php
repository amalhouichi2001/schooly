@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une dépense</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('depenses.store') }}" method="POST">
        @csrf
        <div>
            <label>Description:</label><br>
            <input type="text" name="description" value="{{ old('description') }}" required>
        </div>
        <div>
            <label>Montant (DT):</label><br>
            <input type="number" step="0.01" name="montant" value="{{ old('montant') }}" required>
        </div>
        <div>
            <label>Date:</label><br>
            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
        </div>
        <div>
            <label>Catégorie (optionnel):</label><br>
            <input type="text" name="categorie" value="{{ old('categorie') }}">
        </div>
        <button type="submit">Ajouter</button>
    </form>
</div>
@endsection
