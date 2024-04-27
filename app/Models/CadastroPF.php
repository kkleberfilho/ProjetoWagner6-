<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroPF extends Model
{
    use HasFactory;

    protected $table = 'cadastro_pf'; 
    protected $fillable = [
        'nome_completo',
        'cpf',
        'nascimento',
        'genero',
     
    ];
    public $timestamps = false;

    #Relacionamento inverso
    public function usuario()
    {
        return $this->belongsTo(CadastroUsuario::class, 'cadastro_usuario_id');
    }

}