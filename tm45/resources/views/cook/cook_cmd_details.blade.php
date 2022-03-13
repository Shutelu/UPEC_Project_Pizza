@extends('trame.modele')

@section('title','liste des commandes des utilisateurs')

@section('content')

    <h3>Vous etes sur le details de la commande</h3>
    <table>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Quantité</th>
        </tr>
        @foreach ($pizza as $p)
            <tr>
                <td>{{$p->nom}}</td>
                <td>{{$p->description}}</td>
                <td>{{$p->prix}}</td>
                <td>{{$p->pivot->qte}}</td>
            </tr>
        @endforeach
    </table>
@endsection