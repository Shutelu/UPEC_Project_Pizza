{{--TM45 / page ajout--}}
@extends('trame.modele')

@section('title','Ajout pizza')

@section('title','Page edition')

@section('link')

@section('content')
    <p>Page ajout pizza</p>
    <form action="{{route('pizza.ajout')}}" method="POST">
        @csrf
        <label for="nom">Nom</label>
        <input type="text" id="nom"name="nom" value="{{old('nom')}}">
        <label for="desc">Description</label>
        <input type="text" id="desc" name="desc" value="{{old('desc')}}">
        <label for="prix">Prix</label>
        <input type="number" id="prix" name="prix" value="{{old('prix')}}">
        <button type="submit">envoyer</button>
    </form>   
@endsection