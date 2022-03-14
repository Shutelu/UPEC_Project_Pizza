@extends('trame.modele')

@section('title','Liste de tout les commandes')

{{--les liens css--}}
@section('link')
    
@endsection

{{-- les contenues --}}
@section('content')
    <h1>Liste des toutes les commandes</h1>
    <p>Vous etes sur l'affichage avancée de toutes les commandes qui se trouve dans la base de donnée</p>
    <table>
        <tr>
            <th>Identifiant</th>
            <th>Details</th>
            <th>Statut</th>
            <th>Prix</th>
            <th>Date creation</th>
            <th>Date edition</th>
        </tr>
        @foreach ($commandes as $c)
            <tr>
                <td>{{$c->id}}</td>
                <td><a href="{{route('admin.details_commande',['id'=>$c->id])}}">Détails de la commande</a></td>
                <td>{{$c->statut}}</td>
                <td>{{$c->created_at}}</td>
                <td>{{$c->updated_at}}</td>
            </tr>
        @endforeach
    </table>
    {{$commandes->links()}}
    
@endsection