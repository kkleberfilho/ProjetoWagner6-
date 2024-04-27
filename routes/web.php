<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SobreNosController;
use App\Http\Controllers\CadastroController;

Route::middleware('auth')->group(function () {
    Route::prefix('/app')->group(function(){
         Route::get('/home',[HomeController::class, 'home'])->name('site.home');
    });
});

// Route::get('/home',[HomeController::class, 'home'])->name('site.home');



Route::get('/cadastro', [CadastroController::class, 'cadastro'])->name('site.cadastro');
Route::get('/', [SobreNosController::class, 'sobreNos'])->name('site.sobreNos');

Route::post('/cadastrar', [CadastroController::class, 'processarCadastro'])->name('site.processarCadastro');
Route::get('/login', [LoginController::class, 'login'])->name('site.login');

Route::post('/verificar-login', [LoginController::class, 'verificarLogin'])->name('site.verificarLogin');


Route::get('/cadastro/pf', [CadastroController::class, 'cadastro_pf'])->name('site.cadastro_pf');
Route::post('/cadastro/pf', [CadastroController::class, 'processarCadastroPF'])->name('site.processarCadastroPF');
Route::get('/cadastro/pj', [CadastroController::class, 'cadastro_pj'])->name('site.cadastro_pj');
Route::post('/cadastro/pj', [CadastroController::class, 'processarCadastroPJ'])->name('site.processarCadastroPJ');


Route::fallback(function () {
    echo 'A página que você está procurando não foi encontrada. <a href="'.route('site.sobreNos').'">Clique aqui</a> para voltar para a página inicial.';
});

