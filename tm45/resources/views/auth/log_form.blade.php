@extends('trame.modele')

@section('title','le login')

@section('content')
    <div class="container">
        <div class="content">
            <p>le login</p>
                
                <form method="post">
                    Login: <input type="text" name="login" value="{{old('login')}}">
                    MDP: <input type="password" name="mdp">
                    <input type="submit" value="Envoyer">
                    @csrf
                </form>

            
        </div>
    </div>
@endsection
