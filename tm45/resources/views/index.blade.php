{{--TM45 / page principal / page racine--}}

@extends('trame.modele')

@section('title','Page principal')

@section('link')
    <link rel="stylesheet" href="/styles/index.css">
@endsection



@section('content')

    @guest
        
        <p>Vous n'etes pas encore authentifié</p>
        {{-- <a href="{{route('login')}}">se connecter</a> --}}
        {{-- <a href="{{route('auth.register_form')}}">s'enregistrer</a> --}}
        {{-- <a href="{{route('pizza.ajout_form')}}">ajouter une pizza</a> --}}
            
        <table >
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
            </tr>
            @foreach ($pizza as $p)
                <tr>
                    <td>{{$p->nom}}</td>
                    <td>{{$p->description}}</td>
                    <td>{{$p->prix}}</td>
                </tr>
            @endforeach
        </table>
        {{$pizza->links()}}

    @endguest

    @auth

            <p>Vous etes authentifié</p>
            {{-- <a href="{{route('logout')}}">se deconnecter</a> --}}

            @if($user->type =='admin')
                <a href="{{route('pizza.ajout_form')}}">ajouter une pizzaaaa</a>
            @endif
            
            <table >
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    @if (Auth::user()->type == 'user')
                        <th>Actions</th>
                    @endif
                </tr>
                @foreach ($pizza as $p)
                    <tr>
                        <td>{{$p->nom}}</td>
                        <td>{{$p->description}}</td>
                        <td>{{$p->prix}}</td>

                        @if($user->type == 'user')
                            <td>
                                <form action="{{route('mon_panier_ajout',['id'=>$p->id])}}" method="POST">
                                    @csrf
                                    <button type="submit">Ajouter au panier</button>
                                </form>
                            </td>
                        @endif
                        @if ($user->type == 'admin')
                            <td><a href="{{route('pizza.edit_form',['id'=>$p->id])}}">Modifier la pizza</a></td>
                            <td><a href="{{route('admin.supp_form',['id'=>$p->id])}}">Suprimer la pizza</a></td>
                        @endif
                    </tr>
                @endforeach
            </table>
            {{$pizza->links()}}

    @endauth
@endsection

