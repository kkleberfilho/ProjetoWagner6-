<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\CadastroUsuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        CadastroUsuario::create([
            "tipo_cadastro" => "pf",
            "nome_de_usuario" => "teste",
            "celular" => 123456,
            "email" => "teste@gmail.com",
            "password" => Hash::make(12345678)
        ]);
    }
}
