<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Grenn Points - @yield('titulo')</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
</head>

<body class="fundo">
    <div class="topo">
        <div class="menu">
            <ul>
                <li><a href="{{ route('site.sobreNos') }}">Menu</a></li>
            </ul>
        </div>
    
        <div class="menu menu-right">
            <ul>
                @auth
                <li><a href="{{ route('site.cadastro') }}">{{ Auth::user()->nome_completo}} </a></li>
                
                @else
                {{-- <li><a href="{{ route('site.login') }}">Login</a></li> --}}
                @endauth
            </ul>
        </div>
    </div>
    
    

    <div class="content">
        @yield('conteudo')
    </div>


</body>

<footer>


</footer>

</html>