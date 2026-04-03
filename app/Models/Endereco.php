<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'endereco_rua',
        'endereco_bairro',
        'endereco_numero',
        'endereco_numero',
        'endereco_complemento',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}