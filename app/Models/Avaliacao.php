<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';
    protected $primaryKey = 'avaliacao_id';

    protected $fillable = ['item_id', 'user_id', 'produto_id', 'nota', 'comentario'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id', 'produto_id');
    }
}
