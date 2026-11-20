<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_pedido extends Model
{
    protected $table = 'item_pedidos';
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'pedido_id',
        'produto_id',
        'quantidade',
        'preco_unitario',
        'subtotal',
    ];

     public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id', 'produto_id');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id', 'pedido_id');
    }
}
