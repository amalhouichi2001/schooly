<form method="POST" action="{{ route('notes.store') }}">
    @csrf

    <input type="hidden" name="classe_id" value="{{ $classe_id }}">
    <input type="hidden" name="enseignant_id" value="{{ Auth::id() }}">  <!-- Assurez-vous que l'enseignant_id est bien transmis -->

    @foreach ($eleves as $eleve)
        <div>
            <label>{{ $eleve->nom }}</label>
            <input type="number" name="notes[{{ $eleve->id }}][valeur]" required step="0.01">
            <input type="text" name="notes[{{ $eleve->id }}][matiere]" required>
        </div>
    @endforeach

    <button type="submit">Enregistrer</button>
</form>
