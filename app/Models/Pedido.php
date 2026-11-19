<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $primaryKey = 'pedido_id';

    protected $fillable = [
        'user_id',
        'endereco_id',
        'data_pedido',
        'status',
        'valor_total',
        'forma_pagamento',
    ];
}
