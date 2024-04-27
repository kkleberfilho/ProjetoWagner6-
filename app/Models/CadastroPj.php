<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroPJ extends Model
{
    use HasFactory;

    protected $table = 'cadastro_pj';


    protected $fillable = [
        'cnpj',
        'razao_social',
        'tipo_empresa',
        'inscricao_estadual',
        'nome_fantasia',
        
    ];
    public $timestamps = false;

    #Relacionamento inverso
    public function usuario()
    {
        return $this->belongsTo(CadastroUsuario::class, 'cadastro_usuario_id');
    }
    
}