{{--admin--}}

@extends('trame.modele')

@section('title','Page de gestion')

@section('content')
    @auth
    <div class="content">
        <h1>Page de Gestion</h1>
        <p>Description : Vous êtes sur la page de gestion des admins et des pizzaiolos</p>

        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Login</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>

            @foreach ($cooks as $c)
                <tr>
                    <td>{{$c->id}}</td>
                    <td>{{$c->nom}}</td>
                    <td>{{$c->prenom}}</td>
                    <td>{{$c->login}}</td>
                    <td>{{$c->type}}</td>
                    <td>
                        <a href="{{route('admin.edit_mdp_form',['id'=>$c->id])}}">Changer mdp</a>
                        <a href="{{route('admin.admin_supp_form',['id'=>$c->id])}}">Supprimer</a>
                    </td>
                </tr>
            @endforeach
            @foreach ($admins as $a)
                <tr>
                    <td>{{$a->id}}</td>
                    <td>{{$a->nom}}</td>
                    <td>{{$a->prenom}}</td>
                    <td>{{$a->login}}</td>
                    <td>{{$a->type}}</td>
                    <td><a href="{{route('admin.admin_supp_form',['id'=>$a->id])}}">Supprimer</a></td>
                </tr>
            @endforeach
        </table>
    </div>

    @endauth  
@endsection