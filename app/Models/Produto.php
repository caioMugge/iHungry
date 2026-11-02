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

    public function categorias()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
