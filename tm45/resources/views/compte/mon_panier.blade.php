@extends('trame.modele')

@section('title','Votre panier')

@section('content')
    <p>Vous etes sur le panier de {{$user->nom}}</p>

    {{-- <form action="{{route('cree_commande')}}" method="POST">
        @csrf
        <button type="submit">Cree une nouvelle commande</button>
    </form> --}}

    {{-- <a href="{{route('cree_commande')}}">cree une nouvelle commande</a> --}}

    {{-- @forelse ($commandes as $c)
        @if ($loop->first)
            <ul>
                <li>commande statut : {{$c->statut}}</li>
            </ul>
        @endif
    @empty
        <p>pas encore de commandes</p>
    @endforelse --}}

    <?php $total = 0 ?>
    @if(session('panier'))
        <table>
            <tr>
                <th>Nom</th>
                <th>description</th>
                <th>prix</th>
                <th>quantité</th>
            </tr>
            @foreach ($panier as $id => $opt)
                <?php $total += $opt['prix'] * $opt['qte'] ?>
                <tr>
                    <td>{{$opt['nom']}}</td>
                    <td>{{$opt['desc']}}</td>
                    <td>{{$opt['prix']}}</td>
                    <td>
                        <form action="{{route('mon_panier_ajout',['id'=>$id])}}" method="POST">
                            @csrf
                            <button type="submit">+</button>
                        </form>
                        <form action="{{route('mon_panier_miseajour')}}" method="POST">
                            @csrf
                            <input type="number" value="{{$opt['qte']}}" name="quantite_miseajour">
                            <input type="hidden" name="id_pizza" value="{{$id}}">
                            <button type="submit">changer</button>
                        </form>
                        
                        <form action="{{route('mon_panier_delete',['id'=>$id])}}" method="POST">
                            @csrf
                            <button type='submit'>-</button>
                        </form>

                        <form action="{{route('mon_panier_deleteall',['id'=>$id])}}" method="post">
                            @csrf
                            <button type="submit">supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        <h3>Total : {{$total}}</h3>
        <form action="{{route('cree_commande')}}" method="GET">
            <button>Passer la commande</button>
        </form>
        {{-- {{$panier->links()}}  --}}
    @endif
    

@endsection