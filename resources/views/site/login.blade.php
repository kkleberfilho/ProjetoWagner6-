@extends('site.layout.layoutpaginas')

@section('titulo', 'Login')

@section('conteudo')
    
    <div class="login">
        <div class="login_tamanho">
            <h1>Login</h1>
            <p>Preencha os campos abaixo para acessar o site</p>
            <form action="{{ route('site.verificarLogin') }}" method="post">
                @csrf
                <input type="text" name="email" placeholder="Email" class="borda-preta">
                <br>
                <input type="password" name="senha" placeholder="Senha" class="borda-preta">
                <br>
                @if ($errors->any())
                    <div class="error-message">
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <button type="submit" class="borda-preta">ENVIAR</button>
            </form>
        </div>
    </div>
@endsection
