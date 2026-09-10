<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $primaryKey = 'categoria_id';

    protected $fillable = [
        'nome_categoria',
        'descricao_categoria',
    ];
}
