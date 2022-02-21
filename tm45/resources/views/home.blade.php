{{--une fois autentifier--}}
@extends('trame.modele')

@section('title','Bienvenue')

@section('content')
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