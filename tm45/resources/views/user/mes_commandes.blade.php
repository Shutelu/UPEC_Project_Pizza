@extends('trame.modele')

@section('title','Liste des mes commandes')

@section('content')

    <h1>Liste de vos commandes passées</h1>
    <p>Description : Vous êtes sur la liste de toutes les commandes que vous avez passées !</p>
    <a href="{{route('user.mes_commande_nonRecup')}}">Voir seulement les commandes non reccupérées</a>
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