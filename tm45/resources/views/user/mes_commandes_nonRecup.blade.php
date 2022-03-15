@extends('trame.modele')

@section('title','Liste des mes commandes')

@section('content')

    <h1>Liste de vos commandes passées sans "recupere"</h1>
    <p>Description : Vous êtes sur la liste de vos commandes sans le statut "recupere"</p>
    <a href="{{route('user.mes_commandes')}}">Voir toutes les commandes passées</a>
    <table>
        <tr>
            <th>Lien</th>
            <th>Date</th>
            <th>Statut</th>
        </tr>
        @foreach ($liste as $l)
            <tr>
                <td><a href="{{route('user.mes_commandes_details',['id'=>$l->id])}}">Details de la commande</a></td>
                <td>{{$l->created_at}}</td>
                <td>{{$l->statut}}</td>
            </tr>
        @endforeach
    </table>
    {{$liste->links()}}
@endsection