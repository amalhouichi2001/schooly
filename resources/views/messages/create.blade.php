<form method="POST" action="{{ route('messages.store') }}">
    @csrf
    <select name="to_id" class="form-select">
        @foreach($users as $u)
            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->role }})</option>
        @endforeach
    </select>
    <textarea name="contenu" class="form-control mt-2" placeholder="Message..."></textarea>
    <button type="submit" class="btn btn-primary mt-2">Envoyer</button>
</form>
