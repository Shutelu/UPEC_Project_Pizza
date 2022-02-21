{{--TM45 / page principal / page racine--}}

@extends('trame.modele')

@section('title','Page principal')

@section('link')
    <link rel="stylesheet" href="/styles/index.css">
@endsection

@section('content')
       <div class="container">
           <div class="content">
               
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
@endsection

