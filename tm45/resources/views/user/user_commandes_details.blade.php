@extends('trame.modele')

@section('title','Details de la commande')

@section('content')

    <?php $total = 0 ?>

    <h3>Vous êtes sur le details de votre commande</h3>
    <p>Le statut de votre commande est : {{$commande->statut}}</p>
    <table>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Quantité</th>
        </tr>
        @foreach ($pizza as $p)

            <?php $total += $p['prix'] * $p->pivot->qte ?>

            <tr>
                <td>{{$p->nom}}</td>
                <td>{{$p->description}}</td>
                <td>{{$p->prix}}</td>
                <td>{{$p->pivot->qte}}</td>
            </tr>
        @endforeach
    </table>
    <h3>Total de la commande: {{$total}}</h3>
    <a href="{{route('home')}}">Retour</a>
@endsection