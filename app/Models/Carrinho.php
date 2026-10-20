<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carrinho extends Model
{
    protected $table = 'carrinho_itens';

    protected $fillable = [
        'user_id', 
        'produto_id', 
        'instance', 
        'quantidade'
    ];

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'produto_id', 'produto_id');
    }
}
