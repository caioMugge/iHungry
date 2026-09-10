<?php

// use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'nome_usuario',
        'endereco_id',
        'email',
        'senha',
        'telefone',
        'tipo',
    ];

    // public function enderecos()
    // {
    //     return $this->hasMany(Endereco::class);
    // }
}



