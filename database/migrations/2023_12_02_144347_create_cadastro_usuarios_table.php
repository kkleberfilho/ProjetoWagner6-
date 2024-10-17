<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cadastro_usuarios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('tipo_cadastro');
            $table->string('nome_de_usuario')->unique();
            $table->bigInteger('celular')->unique(); 
            $table->string('password');
            $table->string('email')->unique();
        });

        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadastro_usuario_id')->constrained('cadastro_usuarios');
            $table->string('cep');
            $table->string('logradouro');
            $table->string('numero'); 
            $table->string('bairro');
            $table->string('municipio');
            $table->string('estado');
            $table->string('complemento')->nullable();
        });

        Schema::create('cadastro_pf', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadastro_usuario_id')->constrained();
            $table->string('nome_completo');
            $table->string('cpf')->unique();
            $table->date('nascimento');
            $table->string('genero');
        });

        Schema::create('cadastro_pj', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadastro_usuario_id')->constrained();
            $table->string('cnpj')->unique();
            $table->string('razao_social')->unique();
            $table->string('tipo_empresa');  
            $table->string('inscricao_estadual')->unique()->nullable();
            $table->string('nome_fantasia')->unique()->nullable();
        });

        Schema::create('produtos_pontos_casa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadastro_usuario_id')->constrained();
            $table->foreignId('endereco_id')->constrained();
            $table->string('nome_porduto');
            $table->string('categoria');
            $table->string('tipo');
            $table->integer('pontos');
        });



    } 

    public function down(): void
    {   
        
        Schema::dropIfExists('produtos_pontos_casa');
        Schema::dropIfExists('cadastro_pf');
        Schema::dropIfExists('cadastro_pj');
        Schema::dropIfExists('enderecos');
        Schema::dropIfExists('cadastro_usuarios');
        
    }
};
