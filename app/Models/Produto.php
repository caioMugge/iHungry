<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $primaryKey = 'produto_id';

    protected $fillable = [
        'nome_produto',
        'categoria_id',
        'descricao_produto',
        'preco',
        'imagem',
        'promocao',
        'ativo',
    ];
}
