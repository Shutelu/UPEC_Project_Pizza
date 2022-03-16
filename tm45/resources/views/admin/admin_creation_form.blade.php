{{--admin--}}

@extends('trame.modele')

@section('title','Page de creation d\'un admin')

@section('content')
    @auth
    <div class="content">
        <h1>Page de création d'un admin</h1>
        <p>Description : Vous êtes la page de création d'un administrateur, le mot de passe sera défini à "admin" par defaut</p>

        <form action="{{route('admin.admin_creation')}}" method="POST">
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