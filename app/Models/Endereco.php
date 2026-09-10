<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'endereco';

    protected $primaryKey = 'endereco_id';

    protected $fillable = [
        'endereco_rua',
        'endereco_bairro',
        'endereco_numero',
        'endereco_complemento',
    ];
}
