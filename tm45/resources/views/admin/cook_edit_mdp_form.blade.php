{{--admin--}}

@extends('trame.modele')

@section('title','Page d\'edition de mot de passe')

@section('content')
    @auth
    <div class="content">
        <h1>Page édition de mdp d'un pizzaiolo</h1>
        <p>Description : Vous êtes la page d'édition de mot de passe d'un pizzaiolo'</p>

        <form action="{{route('admin.cook_edit',['id'=>$cook->id])}}" method="POST">
            @csrf
            Nouveau mdp : <input type="password" name="mdp">
            Confirmation : <input type="password" name="mdp_confirmation">
            <button type="submit">Changer</button>
        </form>

        <br>
        <a href="{{route('admin.gestion_form')}}">Retour</a>
    </div>

    @endauth  
@endsection