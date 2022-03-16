{{--admin--}}

@extends('trame.modele')

@section('title','Page de suppression')

@section('content')
    @auth
    <div class="content">
        <h1>Page de Suppression</h1>
        <p>Description : Vous êtes sur le point de supprimer <br> Nom : {{$user->nom}} <br> Prenom : {{$user->prenom}} <br> Type : {{$user->type}}</p>

        <form action="{{route('admin.admin_supp',['id'=>$user->id])}}" method="POST">
            @csrf
            <button type="submit">Confirmer la suppression</button>
        </form>
        <a href="{{route('admin.gestion_form')}}">Retour</a>
    </div>

    @endauth  
@endsection