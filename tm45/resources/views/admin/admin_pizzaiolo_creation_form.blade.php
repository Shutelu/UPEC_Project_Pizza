{{--admin--}}

@extends('trame.modele')

@section('title','Page de creation d\'un pizzaiolo')

@section('content')
    @auth
    <div class="content">
        <h1>Page de création d'un pizzaiolo</h1>
        <p>Description : Vous êtes la page de création d'un pizzaiolo, le mot de passe sera défini à "cook" par défaut</p>

        <form action="{{route('admin.pizzaiolo_creation')}}" method="POST">
            @csrf
            Nom : <input type="text" name="nom" value="{{old('nom')}}">
            Prenom : <input type="text" name="prenom" value="{{old('prenom')}}">
            Login : <input type="text" name="login" value="{{old('login')}}">
            <button type="submit">Crée</button>
        </form>
        <br>
        <a href="{{route('admin.user_creation_form')}}">Retour</a>
    </div>

    @endauth  
@endsection