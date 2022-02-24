{{--affichage des informations de compte--}}

@extends('trame.modele')
@section('title','Votre compte')

{{--les liens css--}}
@section('link')
    
@endsection

{{-- les contenues --}}
@section('content')
    <h1>Vous etes sur votre espace compte</h1>
    <div>
        <p>Nom : {{$user->nom}}</p>
        <p>Prenom : {{$user->prenom}}</p>
        <p>Vous etes : {{$user->type}}</p>
        <a href="{{route('edit_mdp_form')}}">Modifier le mot de passe</a>
    </div>
@endsection