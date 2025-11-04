@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un abonnement</h1>
    <form action="{{ route('abonnements.store') }}" method="POST">
        @csrf
        @include('abonnements._form')
        <button class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
