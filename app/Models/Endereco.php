<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'enderecos'; 

    protected $fillable = [
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'municipio',
        'estado',
        'complemento',
    ];
        
            
    public $timestamps = false;

    protected $guarded = [];

    public function cadastroUsuario()
    {
        return $this->belongsTo(CadastroUsuario::class);
    }
}
