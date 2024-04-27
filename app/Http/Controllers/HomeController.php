<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Endereco;

class HomeController extends Controller
{
    public function home()
    {
        // Verifica se o usuário está autenticado
        if (Auth::check()) {
            // Recupera o usuário autenticado
            $user = Auth::user();

            // Verifica se o usuário possui um endereço associado
            $endereco = $user->endereco;

            // Passa os dados do endereço para a visualização
            return view('site.home', compact('endereco'));
        } 
        // else {
        //     // Se o usuário não estiver autenticado, redireciona para a página de login
        //     return redirect()->route('site.login');
        // }
    }
}
