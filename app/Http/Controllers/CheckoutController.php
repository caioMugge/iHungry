<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Cart;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Item_pedido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected array $metodos = [
        'dinheiro' => 'Dinheiro',
        'cartao_debito' => 'Cartão de débito',
        'cartao_credito' => 'Cartão de crédito',
        'qrcode' => 'QR Code',
    ];

    public function index()
    {
        $cart = Cart::instance('cart');

        if ($cart->content()->isEmpty()) {
            return redirect()->route('cart.index');
        }

        return view('checkout.index', [
            'itens' => $cart->content(),
            'total' => $cart->total(),
            'metodos' => $this->metodos,
        ]);
    }

    public function escolher(Request $request)
    {
        $request->validate([
            'metodo' => 'required|in:' . implode(',', array_keys($this->metodos)),
        ]);

        session(['checkout.metodo' => $request->metodo]);

        return redirect()->route('checkout.pagamento');
    }

    public function pagamento()
    {
        $cart = Cart::instance('cart');
        $metodo = session('checkout.metodo');

        if ($cart->content()->isEmpty() || !$metodo) {
            return redirect()->route('checkout.index');
        }

        return view('checkout.pagamento', [
            'metodo' => $metodo,
            'metodoNome' => $this->metodos[$metodo],
            'total' => $cart->total(),
        ]);
    }

    public function confirmar()
    {
        $cart   = Cart::instance('cart');
        $metodo = session('checkout.metodo');

        if ($cart->content()->isEmpty() || !$metodo) {
            return redirect()->route('checkout.index');
        }

         $ids = $cart->content()->pluck('id');

        $disponiveis = Produto::whereIn('produto_id', $ids)
            ->where('ativo', true)
            ->count();

        if ($disponiveis !== $ids->unique()->count()) {
            return redirect()->route('cart.index')
                ->withErrors(['carrinho' => 'Um ou mais produtos do carrinho não estão mais disponíveis. Remova-os para continuar.']);
        }

        $pedido = DB::transaction(function () use ($cart, $metodo) {
            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'endereco_id' => Auth::user()->endereco_id,
                'data_pedido' => now(),
                // 'status' => 'pendente',
                'status' => Pedido::EM_PREPARO,
                'valor_total' => $cart->total(),
                'forma_pagamento' => $metodo,
            ]);

            foreach ($cart->content() as $item) {
                Item_pedido::create([
                    'pedido_id'      => $pedido->getKey(),
                    'produto_id'     => $item->id,
                    'quantidade'     => $item->quantidade,
                    'preco_unitario' => $item->preco,
                    'subtotal'       => $item->subtotal,
                ]);
            }

            return $pedido;
        });

        session()->flash('checkout.resumo', [
            'pedido_id' => $pedido->getKey(),
            'metodo' => $this->metodos[$metodo],
            'total' => $pedido->valor_total,
        ]);

        $cart->destroy();
        session()->forget('checkout.metodo');

        return redirect()->route('checkout.sucesso');
    }


    public function sucesso()
    {
        if (!session()->has('checkout.resumo')) {
            return redirect()->route('home');
        }

        return view('checkout.sucesso', ['resumo' => session('checkout.resumo')]);
    }


}
