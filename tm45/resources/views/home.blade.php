{{--une fois autentifier--}}
@extends('trame.modele')

@section('title','Bienvenue')


@section('content')
    @auth
            <div class="content">
                <p>Vous authentifier</p>
                {{-- <a href="{{route('logout')}}">se deconnecter</a> --}}

                @if ($user->type == 'admin')
                    <a href="{{route('pizza.ajout_form')}}">ajouter une pizza</a>
                @endif
                
                <table>
                    @foreach ($pizza as $p)
                        <tr>
                            <td>{{$p->nom}}</td>
                            <td>{{$p->description}}</td>
                            <td>{{$p->prix}}</td>
                            <td>Ajouter au panier</td>
                            
                            @if ($user->type =='admin')
                                <td><a href={{route('pizza.edit_form',['id'=>$p->id])}}>edit une pizza</a></td>
                                <td>Suprimer une pizza</td>
                            @endif
                        </tr>
                    @endforeach
                </table>

            </div>

    @endauth    
@endsection