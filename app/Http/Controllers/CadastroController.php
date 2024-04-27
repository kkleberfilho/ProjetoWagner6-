<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CadastroUsuario;
use App\Models\CadastroPF;
use App\Models\CadastroPJ;
use App\Models\Endereco;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;


class CadastroController extends Controller
{
    public function cadastro()
    {
        return view('site.cadastro');
    }

    public function cadastro_pf()
    {
        return view('site.cadastro_pf');
    }

    public function cadastro_pj()
    {
        return view('site.cadastro_pj');
    }



    public function store(Request $request)
    {
        Log::info('Tipo de Cadastro: ' . $request->input('tipo_cadastro'));
       
        #Valida os dados recebidos do form
        $validator = $this->validarCadastro($request->all());
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        DB::beginTransaction();
    
        try {
            #Cria o cadastro usuário 
            $cadastroUsuario = CadastroUsuario::create(Arr::except($request->all(), ['enderecos', 'cadastro_pf', 'cadastro_pj']));
            
           #Faz a associação do endereço ao cadastro usuário 
            $endereco = $this->criarEndereco($request->all(), $cadastroUsuario);
    
            #Reconhece sé é cadastro pf ou pj e direciona os dados para a tabela 
            $tipoCadastro = $request->input('tipo_cadastro');
    
            if ($tipoCadastro === 'pf') {
                $cadastroPF = $this->criarCadastroPF($request->all());
                $cadastroUsuario->cadastro_pf()->save($cadastroPF);
            } elseif ($tipoCadastro === 'pj') {
                $cadastroPJ = $this->criarCadastroPJ($request->all());
                $cadastroUsuario->cadastro_pj()->save($cadastroPJ);
            }
    
        
            DB::commit();
    
            return redirect()->route('site.cadastro_sucesso');
        } catch (\Exception $e) {
            #Da um roolbakc caso os dados esteja errados 
            DB::rollBack();
    
            
            Log::error('Erro durante o cadastro: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'Ocorreu um erro durante o cadastro. Tente novamente.');
        }
    }




    public function processarCadastroPF(Request $request)
    {
        #Faz a validação dos dados do form 
        $validator = $this->validarCadastro($request->all());
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
       #Envia para o armazenamento caso as validações estejam de acordo 
        $this->armazenarCadastroPF($request->all());
    
        
        return redirect()->route('site.login')->with('success', 'Cadastro PF realizado com sucesso!');
    }
    
    


    private function armazenarCadastroPF(array $dadosCadastro)
    {
        
        DB::beginTransaction();

        try {
             #Ele cria o usário principal a qual vai receber os dados principais e deixa de fora os dados de endereço já que vão para outra tabela.  
            $usuario = CadastroUsuario::create(Arr::except($dadosCadastro, ['cep', 'logradouro', 'numero', 'bairro', 'municipio', 'estado', 'complemento']));

            dd($usuario);
            #Faz a associação dos dados que seram exclusivos para pessoa juridica, chamando a função que vai separar os dados
            $pf = $this->criarCadastroPF($dadosCadastro);

             #Salva os dados exlusivos do PF
            $usuario->cadastro_pf()->save($pf);

            #Cria o endereço e associa os dados 
            $endereco = new Endereco(Arr::only($dadosCadastro, ['cep', 'logradouro', 'numero', 'bairro', 'municipio', 'estado', 'complemento']));
            $usuario->endereco()->save($endereco);

           
            DB::commit();
        } catch (\Exception $e) {
         
            DB::rollBack();

           
            Log::error('Erro durante o cadastro PF: ' . $e->getMessage());

            
            return redirect()->back()->with('error', 'Ocorreu um erro durante o cadastro PF. Tente novamente.');
        }

    
        return redirect()->route('site.login')->with('success', 'Cadastro PF realizado com sucesso!');
    }

    
    public function processarCadastroPJ(Request $request)
    {
        #Faz a validação dos dados do form 
        $validator = $this->validarCadastro($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        #Envia para o armazenamento caso as validações estejam de acordo 
        $this->armazenarCadastroPJ($request->all());

        
        return redirect()->route('site.login')->with('success', 'Cadastro PJ realizado com sucesso!');
    }


   
    private function armazenarCadastroPJ(array $dadosCadastro)#Armazenar o cadastro do PJ
    {

        DB::beginTransaction();

        try {
            #Ele cria o usário principal a qual vai receber os dados principais e deixa de fora os dados de endereço já que vão para outra tabela.  
            $usuario = CadastroUsuario::create(Arr::except($dadosCadastro, ['cep', 'logradouro', 'numero', 'bairro', 'municipio', 'estado', 'complemento']));

            #Faz a associação dos dados que seram exclusivos para pessoa juridica, chamando a função que vai separar os dados
            $pj = $this->criarCadastroPJ($dadosCadastro);

            #Salva os dados exlusivos do PJ 
            $usuario->cadastro_pj()->save($pj);

            // Faz a assosição do endereço com o usuário, depois de ter já criado os dados principais do usuario e os exclusivos do PJ
            $endereco = new Endereco(Arr::only($dadosCadastro, ['cep', 'logradouro', 'numero', 'bairro', 'municipio', 'estado', 'complemento']));
            $usuario->endereco()->save($endereco);


            DB::commit();
        } catch (\Exception $e) {
            #Sé caro houver erro no cadastro ele apaga os dados que estavam sendo cadastrados do usuário
            DB::rollBack();

            Log::error('Erro durante o cadastro PJ: ' . $e->getMessage()); 

            return redirect()->back()->with('error', 'Ocorreu um erro durante o cadastro PJ. Tente novamente.');
        }

     
        return redirect()->route('site.login')->with('success', 'Cadastro PJ realizado com sucesso!');
    }




    public function alterarSenha(Request $request, $id)
    {
        // Primeiro, você pode validar os dados recebidos, como a nova senha
        $validator = Validator::make($request->all(), [
            'nova_senha' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Agora, você pode buscar o usuário pelo ID
        $usuario = CadastroUsuario::find($id);

        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuário não encontrado.');
        }

        // Atualize a senha do usuário com a nova senha fornecida
        $usuario->senha = bcrypt($request->input('nova_senha'));
        $usuario->save();

        return redirect()->back()->with('success', 'Senha alterada com sucesso!');
    }






    

    private function criarEndereco(array $dadosCadastro, CadastroUsuario $usuario) #Criação do endereço para o usuário
    {
        
        $endereco = new Endereco([ 
            'cep' => $dadosCadastro['cep'],
            'logradouro' => $dadosCadastro['logradouro'],
            'numero' => $dadosCadastro['numero'],
            'bairro' => $dadosCadastro['bairro'],
            'municipio' => $dadosCadastro['municipio'],
            'estado' => $dadosCadastro['estado'],
            'complemento' => $dadosCadastro['complemento'] ?? null,
        ]);

        
        $usuario->endereco()->save($endereco);

        return $endereco;
    }

    


    
    private function validarCadastro(array $dadosCadastro) #Fazendo a validação dos dados 
    {
        $tipoCadastro = $dadosCadastro['tipo_cadastro'] ?? null;

        $regras = [
            'tipo_cadastro' => 'required|in:pf,pj',
            'nome_de_usuario' => 'required|string|unique:cadastro_usuarios,nome_de_usuario',
            'email' => 'required|email|unique:cadastro_usuarios,email',
            'celular' => 'required|numeric|unique:cadastro_usuarios,celular',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'municipio' => 'required',
            'estado' => 'required',
            'complemento' => 'nullable',
            'senha' => 'required|min:6',
        ];

        $mensagens = [
            'nome_de_usuario.required' => 'O campo nome de usuário é obrigatório.',
             'email.required' => 'Por favor, forneça um endereço de e-mail.',
        ];

        if ($tipoCadastro === 'pf') { #checando as regras de validação da pessoa fisica e juridica
            $regras += $this->regrasCadastroPF();
            $mensagens += $this->mensagensCadastroPF();
        } elseif ($tipoCadastro === 'pj') {
            $regras += $this->regrasCadastroPJ();
            $mensagens += $this->mensagensCadastroPJ();
        }

        $validator = Validator::make($dadosCadastro, $regras, $mensagens);

        return $validator;
    }

    private function preencherDadosUsuario(CadastroUsuario $usuario, array $dados)#Preenchendo os dados dos usuários
    {
        $usuario->nome_de_usuario = $dados['nome_de_usuario'];
        $usuario->email = $dados['email'];
        $usuario->celular = $dados['celular'];
        $usuario->cep = $dados['cep'];
        $usuario->logradouro = $dados['logradouro'];
        $usuario->numero = $dados['numero'];
        $usuario->bairro = $dados['bairro'];
        $usuario->municipio = $dados['municipio'];
        $usuario->estado = $dados['estado'];
        $usuario->complemento = $dados['complemento'] ?? null;
        $usuario->senha = bcrypt($dados['senha']);
    }

    private function criarCadastroPF(array $dadosCadastro)#Cria o cadastro dos dados especificos da pessoa fisica
    {
        return new CadastroPF([
            'cpf' => $dadosCadastro['cpf'],
            'nascimento' => $dadosCadastro['nascimento'],
            'genero' => $dadosCadastro['genero'],
            'nome_completo' => $dadosCadastro['nome_completo'],
        ]);
    }

    private function criarCadastroPJ(array $dadosCadastro)#Cria o cadastro dos dados especificos da pessoa juridica
    {
        return new CadastroPJ([
            'cnpj' => $dadosCadastro['cnpj'],
            'inscricao_estadual' => $dadosCadastro['inscricao_estadual'],
            'tipo_empresa' => $dadosCadastro['tipo_empresa'],
            'razao_social' => $dadosCadastro['razao_social'],
            'nome_fantasia' => $dadosCadastro['nome_fantasia'],
        ]);
    }

    private function regrasCadastroPF()#Regas para validação dos dados, chamado na função validarcadastro
    {
        return [
            'cpf' => 'required|string|unique:cadastro_pf,cpf',
            'nascimento' => 'required|date',
            'genero' => 'required|in:masculino,feminino,outro',
            'nome_completo' => 'required|string',
        ];
    }

    private function mensagensCadastroPF()
    {
        return [
         
        ];
    }

    private function regrasCadastroPJ() #Regas para validação dos dados, chamado na função validarcadastro
    {
        return [
            'cnpj' => 'required|string|unique:cadastro_pj,cnpj',
            'inscricao_estadual' => 'required|string|unique:cadastro_pj,inscricao_estadual',
            'tipo_empresa' => 'required|string',
            'razao_social' => 'required|string',
            'nome_fantasia' => 'required|string',
        ];
    }

    private function mensagensCadastroPJ()
    {
        return [
            
        ];
    }
}
