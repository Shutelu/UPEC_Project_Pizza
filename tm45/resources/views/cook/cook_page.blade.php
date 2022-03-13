@extends('trame.modele')

@section('title','liste des commandes des utilisateurs')

@section('content')

    <h3>Vous etes sur la liste des commandes des utilisateurs</h3>
    <table>
        <tr>
            <th>Lien</th>
            <th>Date</th>
            <th>Statut</th>
        </tr>
        @foreach ($commande as $c)
            <tr>
                <td><a href="{{route('commande_details',['id'=>$c->id])}}">Details de la commande</a></td>
                <td>{{$c->created_at}}</td>
                <td>{{$c->statut}}</td>
            </tr>
        @endforeach
    </table>
@endsection