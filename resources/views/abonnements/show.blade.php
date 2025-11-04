@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails abonnement</h1>
    <ul class="list-group">
        <li class="list-group-item"><strong>ID:</strong> {{ $abonnement->id }}</li>
        <li class="list-group-item"><strong>Nom:</strong> {{ $abonnement->nom }}</li>
        <li class="list-group-item"><strong>Durée (mois):</strong> {{ $abonnement->duree_mois }}</li>
        <li class="list-group-item"><strong>Prix:</strong> {{ number_format($abonnement->prix,2,',',' ') }} €</li>
        <li class="list-group-item"><strong>Actif:</strong> {{ $abonnement->actif ? 'Oui' : 'Non' }}</li>
    </ul>
    <a href="{{ route('abonnements.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection
