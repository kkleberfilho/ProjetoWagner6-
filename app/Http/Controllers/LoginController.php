<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\CadastroUsuario;
use App\Models\Endereco;

class LoginController extends Controller
{
    public function login()
    {
        Log::debug('Login request received.');
        return view('site.login'); 
    }

    public function verificarLogin(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'senha' => 'required|min:6',
            ], [
                'email.required' => 'O campo de e-mail é obrigatório.',
                'email.email' => 'Por favor, insira um endereço de e-mail válido.',
                'senha.required' => 'O campo de senha é obrigatório.',
                'senha.min' => 'A senha deve ter pelo menos :min caracteres.',
            ]);

            Log::debug('Email fornecido: ' . $request->input('email'));
            Log::debug('Senha fornecida: ' . $request->input('senha'));

            $credentials = $request->only('email', 'senha');
            
            // $credentials['senha'] = bcrypt($credentials['senha']);
    

            Log::debug('Attempting authentication with credentials: ' . json_encode($credentials));

            if (Auth::attempt(['email'=> $credentials['email'], 'password'=> $credentials['senha']])) {
                
                Log::debug('Authentication successful.');
                return redirect()->intended(route('site.home'));
            }

           
            Log::debug('Authentication failed.');

            return redirect()->route('site.login')->with('error', 'Credenciais inválidas. Verifique seu e-mail e senha.');
       
        } catch (\Exception $e) {
           
            Log::error('Exception occurred during login: ' . $e->getMessage());
            return redirect()->route('site.login')->with('error', 'Ocorreu um erro durante o processo de login. Por favor, tente novamente mais tarde.');
        }
    }

}
