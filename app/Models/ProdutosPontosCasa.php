<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutosPontosCasa extends Model
{
    use HasFactory;

    # Definindo campos preenchedores para evitar vulnerabilidade de atribuição em massa
    protected $fillable = [
        'nome_produto',
        'categoria',
        'tipo',
        'pontos',
    ];

    # Definindo relacionamento com o modelo Usuário (assumindo um relacionamento muitos para muitos)
    public function usuarios()
    {
        return $this->belongsToMany(CadastroUsuario::class);
    }
}
