@extends('trame.modele')

@section('title','Votre panier')

@section('content')
    <p>Vous etes sur le panier de {{$user->nom}}</p>
    @forelse ($commandes as $c)
        @if ($loop->first)
            <ul>
                <li>commande status : {{$c->status}}</li>
            </ul>
        @endif
    @empty
        <p>pas encore de commandes</p>
    @endforelse
@endsection