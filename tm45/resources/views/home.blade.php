{{--une fois autentifier--}}
@extends('trame.modele')

@section('title','Page Principal')


@section('content')
    @auth
            <div class="content">
                <p>Vous etes authentifié</p>
                {{-- <a href="{{route('logout')}}">se deconnecter</a> --}}

                @if ($user->type == 'admin')
                    <a href="{{route('pizza.ajout_form')}}">ajouter une pizza</a>
                @endif
                
                <table>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        @if (Auth::user()->type == 'user')
                        <td>Actions</td>
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
                            @if ($user->type =='admin')
                                <td><a href={{route('pizza.edit_form',['id'=>$p->id])}}>Modifier la pizza</a></td>
                                <td><a href="{{route('admin.supp_form',['id'=>$p->id])}}">Suprimer la pizza</a></td>
                            @endif
                        </tr>
                    @endforeach
                </table>
                {{$pizza->links()}}
            </div>

    @endauth    
@endsection