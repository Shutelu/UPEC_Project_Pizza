@extends('trame.modele')

@section('title','Liste de tout les pizzas')

{{--les liens css--}}
@section('link')
    
@endsection

{{-- les contenues --}}
@section('content')
    <h1>Gestion des Pizzas</h1>
    <p>Description : Vous êtes sur l'affichage avancée de toutes les pizzas qui se trouve dans la base de donnée !</p>

    @if (Auth::user()->type == 'admin')
        <a href="{{route('pizza.ajout_form')}}">ajouter une pizza</a>
    @endif

    <table>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Date creation</th>
            <th>Date edition</th>
            <th>Date suppression</th>
        </tr>
        @foreach ($pizzas as $p)
            <tr>
                <td>{{$p->nom}}</td>
                <td>{{$p->description}}</td>
                <td>{{$p->prix}}</td>
                <td>{{$p->created_at}}</td>
                <td>{{$p->updated_at}}</td>
                <td>{{$p->deleted_at}}</td>
            </tr>
        @endforeach
    </table>
    {{$pizzas->links()}}
    
@endsection