{{--admin--}}

@extends('trame.modele')

@section('title','page admin')

@section('content')
    @auth
    <div class="content">
        <p>Vous authentifier admin</p>
        @if (Auth::user()->type == 'admin')
            <a href="{{route('pizza.ajout_form')}}">ajouter une pizza</a>
        @endif
    </div>

    @endauth  
@endsection