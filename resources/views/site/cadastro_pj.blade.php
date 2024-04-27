@extends('site.layout.layoutpaginas')

@section('titulo', 'Cadastro PJ')

@section('conteudo')


    <div class="cadastro">
        <div class="cadastro_tamanho">
            <h1>Cadastro</h1>
            <form action="{{ route('site.cadastro_pj') }}" method="post">
                @csrf
                <select name="tipo_cadastro" class="borda-preta" onchange="mostrarCampos()">
                    <option value="pj" @if(old('tipo_cadastro') == 'pj') selected @endif>Pessoa Juridica</option>
                </select>
                @error('tipo_cadastro')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                <br>
                <br>
                <div id="campos-pj" style="display: none;">
                    <input type="email" name="email" id="email-pj" placeholder="Email" class="borda-preta @error('email') error-field @enderror" value="{{ old('email') }}">
                        @error('email')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    <br>
                    <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ" class="borda-preta" @if(old('tipo_cadastro') == 'pj') required @endif>
                        @error('cnpj')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    <br>
                    <input type="text" name="razao_social" id="razao-social" placeholder="Razão Social" class="borda-preta" @if(old('tipo_cadastro') == 'pj') required @endif>
                    <br>
                    <input type="text" name="nome_fantasia" id="nome-fantasia" placeholder="Nome Fantasia" class="borda-preta" @if(old('tipo_cadastro') == 'pj') required @endif>
                    <br>
                    <input type="text" name="inscricao_estadual" id="inscricao-estadual" placeholder="Inscrição Estadual" class="borda-preta" @if(old('tipo_cadastro') == 'pj') required @endif>
                        @error('inscricao_estadual')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    <br>
                    <input type="text" name="tipo_empresa" id="tipo-empresa" placeholder="Tipo Empresa" class="borda-preta" @if(old('tipo_cadastro') == 'pj') required @endif>
                    <br>
                    <input type="tel" name="celular" id="celular" placeholder="Celular" class="borda-preta">
                        @error('celular')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    <br>

                    <h2>Endereço</h2>
                    <input type="text" name="cep" id="cep" placeholder="CEP" class="borda-preta">
                    <br>
                    <input type="text" name="logradouro" id="logradouro" placeholder="Logradouro" class="borda-preta">
                    <br>
                    <input type="text" name="numero" id="numero" placeholder="Número" class="borda-preta">
                    <br>
                    <input type="text" name="bairro" id="bairro" placeholder="Bairro" class="borda-preta">
                    <br>
                    <input type="text" name="municipio" id="municipio" placeholder="Município" class="borda-preta">
                    <br>
                    <input type="text" name="estado" id="estado" placeholder="Estado" class="borda-preta">
                    <br>
                    <input type="text" name="complemento" id="complemento" placeholder="Complemento" class="borda-preta">
                    <br>
                    <h2>Nome do Usuario e Senha</h2>
                    <input type="text" name="nome_de_usuario" id="nome-de-usuario" placeholder="Nome" class="borda-preta">
                        @error('nome')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    <br>
                    <input type="password" name="password" id="senha" placeholder="Senha" class="borda-preta">
                    <br>
                </div>

                <button type="submit" class="borda-preta">ENVIAR</button>
            </form>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <script>
        function mostrarCampos() {
            var tipoCadastro = document.querySelector('select[name="tipo_cadastro"]').value;
            var camposPj = document.getElementById('campos-pj');

            if (tipoCadastro === 'pj') {
                mostrarCamposPJ();
                camposPj.style.display = 'block';
            } else if (tipoCadastro === 'pf') {
                camposPj.style.display = 'none';
            } else {
                camposPj.style.display = 'none';
            }
        }

        function mostrarCamposPJ() {
            var camposPj = document.getElementById('campos-pj');
            camposPj.style.display = 'block';
        }

        document.querySelector('select[name="tipo_cadastro"]').addEventListener('change', function () {
            mostrarCampos();
        });

        window.onload = function () {
            mostrarCampos();
        };
    </script>


@endsection


