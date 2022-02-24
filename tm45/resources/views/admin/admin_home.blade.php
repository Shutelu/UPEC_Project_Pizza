{{--admin--}}

@extends('trame.modele')

@section('title','page admin')

@section('content')
    @auth
    <div class="content">
        <p>Vous authentifier admin</p>
        
    </div>

    @endauth  
@endsection