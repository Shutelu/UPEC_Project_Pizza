{{--TM45 / page modele--}}

<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8">

        {{-- section pour l'ajout de style --}}
        <link rel="stylesheet" href="/styles/index.css">
        {{--ajout bootstrap--}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
        @section('link')
            
        @show
    </head>
    <body>
        <div class="bg_img">

                {{-- barre de navigation --}}
                <nav class="navigation">
                    <ul>
                        <li><a href="{{route('index')}}">Accueil</a></li>
                        @auth
                            @if (Auth::user()->type == 'user') 
                                <li><a href="{{route('mon_panier')}}">Mon Panier</a></li>
                            @endif
                            {{-- @yield('compte') --}}
                            @if (Auth::user()->type == 'cook')
                                <li><a href="{{route('cook_liste')}}">Liste des commandes</a></li>
                            @endif
                            <li><a href="{{route('mon_compte')}}">Mon compte</a></li>
                            <li><a href="{{route('logout')}}">Se deconnecter</a></li>
                        @endauth
                        @guest
                            <li><a href="{{route('login')}}">Se connecter</a></li>
                            <li><a href="{{route('auth.register_form')}}">S'inscrire</a></li>
                        @endguest
                    </ul>
                </nav>
                
                {{-- message flash --}}
                @if (session()->has('etat'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{session()->get('etat')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                {{-- tout le contenu --}}
                <div class="contenu">
                    @yield('content')
                </div>
    
            </div>


    </body>
</html>
