@extends('site.layout.layoutpaginas')

@section('titulo', 'Cadastro')


@section('conteudo')
   
    <div class="cadastro">
        <div class="cadastro_tamanho"> 
            <h1>Cadastro</h1>
               <form action="{{ route('site.processarCadastro') }}" method="post">
                    @csrf
                    <select name="tipo_cadastro" class="borda-preta" onchange="redirecionarParaCadastro()">
                        <option value="">Escolha o tipo de cadastro</option>
                        <option value="pf" @if(old('tipo_cadastro') == 'pf') selected @endif>Pessoa Física</option>
                        <option value="pj" @if(old('tipo_cadastro') == 'pj') selected @endif>Pessoa Jurídica</option>
                    </select>
                </form>

        </div>
    </div>    


    <script defer>
        function redirecionarParaCadastro() {
            var tipoCadastro = document.querySelector('select[name="tipo_cadastro"]').value;

            if (tipoCadastro === 'pf') {
                window.location.href = "{{ route('site.cadastro_pf') }}";
            } else if (tipoCadastro === 'pj') {
                window.location.href = "{{ route('site.cadastro_pj') }}";
            }
        }
    </script>

@endsection



