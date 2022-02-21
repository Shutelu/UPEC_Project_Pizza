{{--TM45 / page modele--}}

<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8">

        {{-- section pour l'ajout de style --}}
        {{--ajout bootstrap--}}
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
        @section('link')
            
        @show
    </head>
    <body>
        
        @yield('content')

    </body>
</html>
