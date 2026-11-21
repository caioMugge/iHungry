<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Produto extends Model
{
    protected $primaryKey = 'produto_id';

    protected $fillable = [
        'nome_produto',
        'categoria_id',
        'descricao_produto',
        'preco',
        'preco_promocional',
        'imagem',
        'promocao',
        'ativo',
    ];

    // NOVO
    protected $casts = [
        'ativo' => 'boolean',
        'promocao' => 'boolean',
    ];

    public function categorias()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // NOVO

    protected function emPromocao(): Attribute
    {
        return Attribute::get(fn () =>
        $this->promocao
        && $this->preco_promocional !== null
        && (float) $this->preco_promocional < (float) $this->preco
        );
    }

    protected function precoFinal(): Attribute
    {
        return Attribute::get(fn () =>
        $this->em_promocao ? (float) $this->preco_promocional : (float) $this->preco
        );
    }

    protected function descontoPercentual(): Attribute
    {
         return Attribute::get(fn () =>
            $this->em_promocao
                ? (int) round((1 - $this->preco_promocional / $this->preco) * 100)
                : 0
        );
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'produto_id', 'produto_id');
    }
}
