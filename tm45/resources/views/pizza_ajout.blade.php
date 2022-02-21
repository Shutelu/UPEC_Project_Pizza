{{--TM45 / page ajout--}}
@extends('trame.modele')

@section('title','Ajout pizza')

@section('title','Page edition')

@section('link')

@section('content')
    <p>Page ajout pizza</p>
    <form action="{{route('pizza.ajout')}}" method="POST">
        @csrf
        <input type="text" name="nom" value="{{old('nom')}}">
        <input type="text" name="desc" value="{{old('desc')}}">
        <input type="number" name="prix" value="{{old('prix')}}">
        <button type="submit">envoyer</button>
    </form>   
@endsection