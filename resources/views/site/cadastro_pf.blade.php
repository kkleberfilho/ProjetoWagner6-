@extends('site.layout.layoutpaginas')

@section('titulo', 'Cadastro PF')

@section('conteudo')

    <div class="cadastro">
        <div class="cadastro_tamanho">
            <h1>Cadastro</h1>
            <form action="{{ route('site.cadastro_pf') }}" method="post">
                @csrf
                <select name="tipo_cadastro" class="borda-preta" onchange="mostrarCampos()">
                    <option value="pf" @if(old('tipo_cadastro') == 'pf') selected @endif>Pessoa Física</option>
                </select>
                @error('tipo_cadastro')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                <br>

                <div id="campos-pf" style="display: none;">
                    <input type="text" name="nome_completo" placeholder="Nome Completo" class="borda-preta" @if(old('tipo_cadastro') == 'pf') required @endif>
                        @error('nome_completo')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    <br>
                    <input type="email" name="email" placeholder="Email" class="borda-preta @error('email') error-field @enderror"value="{{ old('email') }}">
                        @error('email')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    <br>
                   <input type="text" name="cpf" placeholder="CPF" class="borda-preta" 									@if(old('tipo_cadastro') == 'pf') required @endif>
                        @error('cpf')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    <br>
                    <input type="date" name="nascimento" placeholder="Nascimento" class="borda-preta" 						@if(old('tipo_cadastro') == 'pf') required @endif>
                    <br>
                   <input type="tel" name="celular" placeholder="Celular" class="borda-preta" 							@if(old('tipo_cadastro') == 'pf') required @endif>
                        @error('celular')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    <br>
                    <select name="genero" class="borda-preta" @if(old('tipo_cadastro') == 'pf') required 			@endif>
                        <option value="">Selecione o gênero</option>
                        <option value="masculino">Masculino</option>
                        <option value="feminino">Feminino</option>
                        <option value="outro">Outro</option>
                    </select>
                    <br>

                    <h2>Endereço</h2>
                    <input type="text" name="cep" placeholder="CEP" class="borda-preta">
                    <br>
                    <input type="text" name="logradouro" placeholder="Logradouro" class="borda-preta">
                    <br>
                    <input type="text" name="numero" placeholder="Número" class="borda-preta">
                    <br>
                    <input type="text" name="bairro" placeholder="Bairro" class="borda-preta">
                    <br>
                    <input type="text" name="municipio" placeholder="Município" class="borda-preta">
                    <br>
                    <input type="text" name="estado" placeholder="Estado" class="borda-preta">
                    <br>
                    <input type="text" name="complemento" placeholder="Complemento" class="borda-preta">
                    <br>

                    <h2>Nome do Usuario e Senha</h2>
                    <input type="text" name="nome_de_usuario" placeholder="Nome" class="borda-preta">
                    @error('nome')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                    <br>
                    <input type="password" name="password" placeholder="Senha" class="borda-preta">
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
            var camposPf = document.getElementById('campos-pf');

            if (tipoCadastro === 'pf') {
                mostrarCamposPF();
                camposPf.style.display = 'block';
            } else if (tipoCadastro === 'pj') {
                camposPf.style.display = 'none';
            } else {
                camposPf.style.display = 'none';
            }
        }


        function mostrarCamposPF() {
            var camposPf = document.getElementById('campos-pf');
            camposPf.style.display = 'block';
        }

        document.querySelector('select[name="tipo_cadastro"]').addEventListener('change', function () {
            mostrarCampos();
        });

        // Chamando a função ao carregar a página para garantir que os campos sejam exibidos corretamente
        window.onload = function () {
            mostrarCampos();
        };

    </script>

@endsection

