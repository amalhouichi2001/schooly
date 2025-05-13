<div class="mb-3">
    <label>Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $parent->nom ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>Prénom</label>
    <input type="text" name="prenom" value="{{ old('prenom', $parent->prenom ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $parent->email ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>Téléphone</label>
    <input type="text" name="telephone" value="{{ old('telephone', $parent->telephone ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Adresse</label>
    <input type="text" name="adresse" value="{{ old('adresse', $parent->adresse ?? '') }}" class="form-control">
</div>
