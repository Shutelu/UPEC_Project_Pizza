@extends('trame.modele')

@section('title','Liste de tout les commandes')

{{--les liens css--}}
@section('link')
    
@endsection

{{-- les contenues --}}
@section('content')
    <h1>Gestion des commandes</h1>
    <br>
    <p>Description : Vous êtes sur l'affichage avancée de toutes les commandes qui se trouve dans la base de donnée !</p>

    <form action="{{route('admin.admin_voir_commande_date')}}" method="POST">
        @csrf
        Voir la liste des commandes d'une date spécifique : <br>
        Saisi au format : YYYY-MM-DD
        <input type="text" name="laDate">
        <button type="submit">Envoyer</button>
    </form>

    <a href="{{route('admin.commande_tri_statut')}}">Trier les commandes par statut</a><br>
    <a href="{{route('admin.commande_tri_date')}}">Trier les commandes par date</a>

    <table>
        <tr>
            <th>Identifiant</th>
            <th>Details</th>
            <th>Statut</th>
            <th>Date creation</th>
            <th>Date edition</th>
            <th>Total de la commande</th>
        </tr>
        @foreach ($commandes as $c)
            <tr>
                <td>{{$c->id}}</td>
                <td><a href="{{route('admin.details_commande',['id'=>$c->id])}}">Détails de la commande</a></td>
                <td>{{$c->statut}}</td>
                <td>{{$c->created_at}}</td>
                <td>{{$c->updated_at}}</td>
                <td>
                    <?php $total=0 ?>
                    @foreach ($c->pizza as $p)
                        <?php 
                            $total += $p->prix *$p->pivot->qte;
                        ?>
                    @endforeach
                    {{$total}} euros
                </td>
            </tr>
        @endforeach
    </table>
    {{$commandes->links()}}

    <br>
    <br>
    <h3>La recette du jour est de {{$recette}} euros</h3>
    
@endsection