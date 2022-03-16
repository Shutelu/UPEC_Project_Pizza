{{--admin--}}

@extends('trame.modele')

@section('title','Page de creation')

@section('content')
    @auth
    <div class="content">
        <h1>Page de création</h1>
        <p>Description : Vous êtes sur la page de création d'un admin ou d'un pizzaiolo</p>

        <a href="{{route('admin.admin_creation_form')}}">Cree un nouveau administrateur</a><br>
        <a href="{{route('admin.pizzaiolo_creation_from')}}">Cree un nouveau pizzaiolo</a>
    </div>

    @endauth  
@endsection