<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Grenn Points - @yield('titulo')</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/jquery.mask.js') }}"></script>
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
                <li><a href="{{ route('site.login') }}">Login</a></li>
                <li><a href="{{ route('site.cadastro') }}">Cadastro</a></li>
            </ul>
        </div>


    </div>

    <div class="content">
        @yield('conteudo')
    </div>


</body>

<footer>

    <div class="footer">


        
    </div>

</footer>


</html>