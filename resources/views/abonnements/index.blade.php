@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Abonnements</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('abonnements.create') }}" class="btn btn-primary mb-3">Créer</a>

    <form method="GET" class="mb-3">
        <select name="actif" onchange="this.form.submit()">
            <option value="">-- Tous --</option>
            <option value="1" {{ request('actif') === '1' ? 'selected' : '' }}>Actifs</option>
            <option value="0" {{ request('actif') === '0' ? 'selected' : '' }}>Inactifs</option>
        </select>
    </form>

    <table class="table">
        <thead><tr><th>ID</th><th>Nom</th><th>Durée (mois)</th><th>Prix</th><th>Actif</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($abonnements as $a)
            <tr>
                <td>{{ $a->id }}</td>
                <td>{{ $a->nom }}</td>
                <td>{{ $a->duree_mois }}</td>
                <td>{{ number_format($a->prix, 2, ',', ' ') }} €</td>
                <td>{{ $a->actif ? 'Oui' : 'Non' }}</td>
                <td>
                    <a href="{{ route('abonnements.show', $a) }}" class="btn btn-sm btn-info">Voir</a>
                    <a href="{{ route('abonnements.edit', $a) }}" class="btn btn-sm btn-warning">Éditer</a>
                    <form action="{{ route('abonnements.destroy', $a) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Supprimer ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $abonnements->links() }}
</div>
@endsection
