@extends('trame.modele')

@section('title','Details de la commande')

@section('content')

    <?php $total = 0 ?>

    <h3>Vous etes sur le details de la commande</h3>
    <p>Le statut de la commande est : {{$commande->statut}}</p>
    <table>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Quantité</th>
        </tr>
        @foreach ($pizzas as $p)

            <?php $total += $p['prix'] * $p->pivot->qte ?>

            <tr>
                <td>{{$p->nom}}</td>
                <td>{{$p->description}}</td>
                <td>{{$p->prix}}</td>
                <td>{{$p->pivot->qte}}</td>
            </tr>
        @endforeach
    </table>
    <h3>Total : {{$total}}</h3>
    <a href="{{route('home')}}">Retour</a>
@endsection