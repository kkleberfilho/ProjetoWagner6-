<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CadastroUsuario extends Model implements Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'tipo_cadastro', 'nome_de_usuario', 'celular', 'email',
         'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public $timestamps = false;

    #Criptografia de senha
    public function setSenhaAttribute($value)
    {
        Log::debug('Senha antes de ser hashada: ' . $value);
        $hashedPassword = bcrypt($value);
        Log::debug('Senha depois de ser hashada: ' . $hashedPassword);
        $this->attributes['password'] = $hashedPassword;
    }


    #Relacionamento Endereço
    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'cadastro_usuario_id');
    }

    #Relacionamento Pf
    public function cadastro_pf()
    {
        return $this->hasOne(CadastroPF::class, 'cadastro_usuario_id');
    }

    #Relacionamento PJ
    public function cadastro_pj()
    {
        return $this->hasOne(CadastroPJ::class, 'cadastro_usuario_id');
    }
}
