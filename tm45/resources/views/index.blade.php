{{--TM45 / page principal / page racine--}}

@extends('trame.modele')

@section('title','Page principal')

@section('link')
    <link rel="stylesheet" href="/styles/index.css">
@endsection

@section('content')
    @guest
        <div class="container">
            <div class="content">
            <p>pas encore authentifier</p>
            <a href="{{route('login')}}">se connecter</a>
            <a href="{{route('auth.register_form')}}">s'enregistrer</a>
            {{-- <a href="{{route('pizza.ajout_form')}}">ajouter une pizza</a> --}}
            
            <table>
                @foreach ($pizza as $p)
                    <tr>
                        <td>{{$p->nom}}</td>
                        <td>{{$p->description}}</td>
                        <td>{{$p->prix}}</td>
                        
                    </tr>
                @endforeach
            </table>

            </div>
        </div>
    @endguest
    @auth
    <div class="container">
        <div class="content">
            <p>authentifier</p>
            <a href="{{route('logout')}}">se deconnecter</a>
            
            <a href="{{route('pizza.ajout_form')}}">ajouter une pizza</a>
            
            <table>
                @foreach ($pizza as $p)
                    <tr>
                        <td>{{$p->nom}}</td>
                        <td>{{$p->description}}</td>
                        <td>{{$p->prix}}</td>
                        <td><a href={{route('pizza.edit_form',['id'=>$p->id])}}>edit une pizza</a></td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
    @endauth
@endsection

