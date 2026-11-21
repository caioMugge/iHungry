<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Item_pedido;
use App\Models\Pedido;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    public function store(Request $request, Item_pedido $item)
    {
        $item->load('pedido');

        // só o dono do pedido pode avaliar
        abort_unless($item->pedido->user_id === $request->user()->getKey(), 403);

        // só depois de entregue
        if ($item->pedido->status !== Pedido::ENTREGUE) {
            return back()->withErrors(['avaliacao' => 'Você só pode avaliar depois que o pedido for entregue.']);
        }

        // uma avaliação por item
        if ($item->avaliacao()->exists()) {
            return back()->withErrors(['avaliacao' => 'Este item já foi avaliado.']);
        }

        $dados = $request->validate([
            'nota'       => 'required|integer|between:1,5',
            'comentario' => 'nullable|string|max:500',
        ]);

        Avaliacao::create([
            'item_id'    => $item->item_id,
            'user_id'    => $request->user()->getKey(),
            'produto_id' => $item->produto_id,
            'nota'       => $dados['nota'],
            'comentario' => $dados['comentario'] ?? null,
        ]);

        return back()->with('success', 'Obrigado pela sua avaliação!');
    }
}
