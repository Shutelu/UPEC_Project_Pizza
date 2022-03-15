{{--TM45 / page edit--}}

@extends('trame.modele')

@section('title','Page edition')

@section('link')
    
@endsection

@section('content')

    <div class="container">
        <div class="content">
            <form action={{route('pizza.edit',['id' => $pizza->id])}} method="POST">
                @csrf
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" value="{{$pizza->nom}}">
                <label for="desc">Description</label>
                <input type="text" id="desc" name="desc" value="{{$pizza->description}}">
                <label for="prix">Prix</label>
                <input type="text" id="prix" name="prix" value="{{$pizza->prix}}">
                <button type="submit">envoyer</button>
            </form>
            <a href="{{route('home')}}">Retour</a>
        </div>
    </div>

@endsection