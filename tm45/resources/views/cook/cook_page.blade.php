@extends('trame.modele')

@section('title','liste des commandes des utilisateurs')

@section('content')

    <h3>Liste des commandes non traités</h3>
    <p>Description : Vous êtes sur la liste de toutes les commandes sans le statut "traitement" triées par le moment d'arrivé (de création)</p>
    <table>
        <tr>
            <th>No</th>
            <th>Lien</th>
            <th>Date</th>
            <th>Statut</th>
        </tr>
        @foreach ($commande as $c)
            <tr>
                <td>{{$c->id}}</td>
                <td><a href="{{route('commande_details',['id'=>$c->id])}}">Details de la commande</a></td>
                <td>{{$c->created_at}}</td>
                <td>{{$c->statut}}</td>
            </tr>
        @endforeach
    </table>
@endsection