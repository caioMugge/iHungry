<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{

    public const EM_PREPARO = 'em_preparo';
    public const SAIU_PARA_ENTREGA = 'saiu_para_entrega';
    public const ENTREGUE = 'entregue';

    protected $primaryKey = 'pedido_id';

    protected $fillable = [
        'user_id',
        'endereco_id',
        'data_pedido',
        'status',
        'valor_total',
        'forma_pagamento',
    ];

    protected $casts = [
        'data_pedido' => 'datetime',
    ];

    public function itens()
    {
        return $this->hasMany(Item_pedido::class, 'pedido_id', 'pedido_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'endereco_id', 'endereco_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::EM_PREPARO        => 'Pedido em preparo',
            self::SAIU_PARA_ENTREGA => 'Saiu para entrega',
            self::ENTREGUE          => 'Entregue',
            default                 => ucfirst($this->status),
        };
    }
}
