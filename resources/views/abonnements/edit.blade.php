@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Éditer un abonnement</h1>
    <form action="{{ route('abonnements.update', $abonnement) }}" method="POST">
        @csrf
        @method('PUT')
        @include('abonnements._form')
        <button class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
