<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoAdminController extends Controller
{
     public function index()
    {
        $pedidos = Pedido::with(['user', 'endereco', 'itens.produto'])
            ->orderByRaw("FIELD(status, ?, ?, ?)", [
                Pedido::EM_PREPARO, Pedido::SAIU_PARA_ENTREGA, Pedido::ENTREGUE,
            ])
            ->latest('data_pedido')
            ->get();

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function saiu(Pedido $pedido)
    {
        if ($pedido->status !== Pedido::EM_PREPARO) {
            return back()->withErrors(['pedido' => 'Só pedidos em preparo podem sair para entrega.']);
        }

        $pedido->update(['status' => Pedido::SAIU_PARA_ENTREGA]);

        return back()->with('success', "Pedido #{$pedido->pedido_id} saiu para entrega.");
    }
}
