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
                <input type="text" name="nom" value="{{$pizza->nom}}">
                <input type="text" name="desc" value="{{$pizza->description}}">
                <input type="text" name="prix" value="{{$pizza->prix}}">
                <button type="submit">envoyer</button>
            </form>
        </div>
    </div>

@endsection