<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $table = 'users';

    protected $fillable = [
        'nome_usuario',
        'endereco_id',
        'email',
        'senha',
        'telefone',
        'tipo',
    ];

    protected $hidden = ['senha'];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    // public function enderecos()
    // {
    //     return $this->hasMany(Endereco::class);
    // }
}



