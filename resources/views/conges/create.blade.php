@extends('layouts.app')

@section('content')
<style>
    .form-container { max-width: 600px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd; font-family: Arial, sans-serif; }
    .form-container h2 { margin-bottom: 20px; font-size: 22px; color: #333; }
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 6px; font-weight: bold; }
    input[type="date"], select, textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
    textarea { resize: vertical; }
    .submit-btn { padding: 10px 16px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; }
    .submit-btn:hover { background-color: #45a049; }
</style>

<div class="form-container">
    <h2>Nouvelle Demande de Congé</h2>

    <form action="{{ route('conges.store') }}" method="POST">
    @csrf

    <label>Date de début</label>
    <input type="date" name="date_debut" required>

    <label>Date de fin</label>
    <input type="date" name="date_fin" required>

    <label>Type</label>
    <select name="type">
        <option value="annuel">Annuel</option>
        <option value="maladie">Maladie</option>
        <option value="exceptionnel">Exceptionnel</option>
    </select>

    <label>Motif</label>
    <textarea name="motif"></textarea>

    <button type="submit">Soumettre</button>
</form>

</div>
@endsection
