<div class="form-group mb-2">
    <label for="nom">Nom</label>
    <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', isset($abonnement) ? $abonnement->nom : '') }}">
    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-group mb-2">
    <label for="duree_mois">Durée (mois)</label>
    <input type="number" name="duree_mois" id="duree_mois" class="form-control @error('duree_mois') is-invalid @enderror" value="{{ old('duree_mois', isset($abonnement) ? $abonnement->duree_mois : '') }}">
    @error('duree_mois')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-group mb-2">
    <label for="prix">Prix</label>
    <input type="text" name="prix" id="prix" class="form-control @error('prix') is-invalid @enderror" value="{{ old('prix', isset($abonnement) ? $abonnement->prix : '') }}">
    @error('prix')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-check mb-2">
    <input type="checkbox" name="actif" id="actif" class="form-check-input" value="1" {{ old('actif', isset($abonnement) ? $abonnement->actif : true) ? 'checked' : '' }}>
    <label for="actif" class="form-check-label">Actif</label>
</div>
