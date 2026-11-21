<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $pedidos = Pedido::where('user_id', $request->user()->getKey())
            ->latest('data_pedido')
            ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    public function show(Request $request, Pedido $pedido)
    {
        abort_unless($pedido->user_id === $request->user()->getKey(), 403);

        // $pedido->load('itens.produto');
        $pedido->load('itens.produto', 'itens.avaliacao');

        return view('pedidos.show', compact('pedido'));
    }

    public function entregue(Request $request, Pedido $pedido)
    {
        abort_unless($pedido->user_id === $request->user()->getKey(), 403);

        if ($pedido->status !== Pedido::SAIU_PARA_ENTREGA) {
            return back()->withErrors(['pedido' => 'Este pedido ainda não saiu para entrega.']);
        }

        $pedido->update(['status' => Pedido::ENTREGUE]);

        return back()->with('success', 'Obrigado! Entrega confirmada.');
    }
}
