<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\Produto;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add_to_cart(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer|min:1', 
        ]);

        $produto = Produto::findOrFail($request->produto_id);

        // dd($produto->only(['produto_id', 'nome_produto', 'preco']));

        Cart::instance('cart')->add(
            $produto->produto_id, 
            $produto->nome_produto, 
            (int) $request->quantidade, 
            $produto->preco
        )->associate(Produto::class); 
        return back()->with('success', 'Produto inserido no carrinho com sucesso!');
    }

    public function update_cart(Request $request)
    {
        $request->validate([
            'rowId' => 'required|string',
            'acao' => 'required|in:aumentar,diminuir',
        ]);

        $cart = Cart::instance('cart');
        $item = $cart->get($request->rowId);

        $quantidade = $request->acao === 'aumentar'
            ? $item->quantidade + 1
            : max(1, $item->quantidade - 1);

        Cart::instance('cart')->update(
            $request->rowId, 
            // (int) $request->quantidade);
            $quantidade,
        );
        return back()->with('success', 'Carrinho atualizado com sucesso!');
    }

    public function remove_from_cart(string $rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return back()->with('success', 'Item removido do carrinho com sucesso');
    }

    public function clear_cart()
    {
        Cart::instance('cart')->destroy();
        return back()->with('success', 'Todos os itens do carrinho foram removidos');
    }
}
