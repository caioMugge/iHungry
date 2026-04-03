<?php

use App\Models\Endereco;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nome_usuario',
        'email',
        'senha',
        'telefone',
        'tipo',
    ];

    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }
}



