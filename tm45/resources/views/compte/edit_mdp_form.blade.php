{{--edition du mdp--}}

@extends('trame.modele')
@section('title','Modification de mdp')

{{--les liens css--}}
@section('link')
    
@endsection


{{-- les contenues --}}
@section('content')
    <h1>Vous etes sur la modification de mdp</h1>
    <div>
        <form action="{{route('edit_mdp')}}" method="POST">
            @csrf
            Ancien : <input type="password" name="ancien">
            Nouveau mdp: <input type="password" name="mdp">
            Confimation mdp: <input type="password" name="mdp_confirmation">
            <button type="submit">Envoyer</button>
        </form>
    </div>
@endsection