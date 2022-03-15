@extends('trame.modele')

@section('title','Details de la commande')

@section('content')

    <h3>Vous êtes sur le details de la commande</h3>
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

    {{-- changement de statut --}}
    <form action="{{route('change_statut_traitement',['id'=>$commande->id])}}" method="POST">
        @csrf
        <button>Mettre la commande en traitement</button>
    </form>
    <form action="{{route('change_statut_pret',['id'=>$commande->id])}}" method="POST">
        @csrf
        <button>Mettre la commande en pret</button>
    </form>
    <form action="{{route('change_statut_recupere',['id'=>$commande->id])}}" method="POST">
        @csrf
        <button>Mettre la commande en recupere</button>
    </form>
    <br>
    <a href="{{route('home')}}">Retour</a>
@endsection