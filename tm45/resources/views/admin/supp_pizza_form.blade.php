@extends('trame.modele')

@section('title','Suppression de la pizza')

{{--les liens css--}}
@section('link')
    
@endsection

{{-- les contenues --}}
@section('content')
    <h1>Vous êtes sur la suppression d'une pizza</h1>
    <table>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
        </tr>
        <tr>
            <td>{{$pizza->nom}}</td>
            <td>{{$pizza->description}}</td>
            <td>{{$pizza->prix}}</td>
        </tr>
    </table>
    @if ($bool)
        <p>Cette pizza existe dans une ou plusieurs commande(s), le mecanisme de softdelete sera utilisé </p>
        <p>Voulez vous vraiment supprimer la pizza ?</p>
        <form action="{{route('admin.supp_pizza',['id'=>$pizza->id])}}" method="POST">
            @csrf
            <button type="submit">Oui</button>
        </form>
        <a href="{{route('home')}}">Retour</a>
        
    @endif
    @if (!$bool)
        <p>Cette pizza n'exite dans aucune commande, la pizza sera supprimer definitivement de la base de donnée</p>
        <p>Voulez vous vraiment supprimer la pizza ?</p>
        <form action="{{route('admin.supp_pizza',['id'=>$pizza->id])}}" method="POST">
            @csrf
            <button type="submit">Oui</button>
        </form>
        <a href="{{route('home')}}">Retour</a>
    @endif
@endsection