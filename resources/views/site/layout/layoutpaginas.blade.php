<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Grenn Points - @yield('titulo')</title>
    <meta charset="utf-8">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        p, span {
            color: #000000;
        }

        h1 {
            color: #000000;
            font-size: 28px;
            display: flex;
            justify-content:center;
        }

        h2 {
            color: #333333;
            font-size: 22px;
            display: flex;
            justify-content:center;
            
        }

        input, select, textarea, button, button:hover{
            width: 100%;
            padding: 10px 15px;
            margin: 10px 0px 10px 0px;
            box-sizing: border-box;
            border-radius: 3px;
            color: #333;
        }

        .borda-preta {
            border: solid 1px #000000;
        }

        button {
            background-color: #77dd77;
            cursor: pointer;
            color: #000000;
        }

        button:hover {
            background-color: #6ea22c;
        }

        ::placeholder {
            color: #333333;
            opacity: 1;
        }

        :-ms-input-placeholder {
            color: #333333;
        }

        ::-ms-input-placeholder {
            color: #333333;
        }

        .topo {
            width: 100%;
            background-color: #ddf3e2;
            padding: 20px 0px 10px 0px;
            height: 20px;  
            overflow: hidden; 
        }
        .fundo {
            position:relative;
            background-color: #eff9f2;
            width: 100%;
            height:100%  
        }

        .logo {
            width: 30px;
            float: left;
            margin-left: 40px;
        }

        .menu {
            float: left; /
            margin-left: 20px; 
        }

        .menu ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .menu ul li {
            display: inline;
        }

        .menu ul li a {
            text-decoration: none;
            padding: 14px 16px;
            color: #333;
        }

        .menu ul li a:hover {
            color: #268fd0;
        }

        .menu-right {
            float: right; 
            margin-right: 40px; 
        }

        

            .cadastro {
            display:flex;
            justify-content:center;

        }

        .cadastro_tamanho{
            width:70%;

        }

        .error-message {
            color: #ff0000;
            font-size: 14px;
        }

        .sobreNos{
            display:flex;
            justify-content:center;
            

        }

        .login{
            display:flex;
            justify-content:center;

        }
        .login_tamanho{
            width:70%;
        }

        .error-field {
            border: 2px solid #ff0000;
        }
    </style>
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

</html>