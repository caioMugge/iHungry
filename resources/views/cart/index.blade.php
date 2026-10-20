@extends('layouts.master')

@section('content')

{{-- @dd(Cart::instance('cart')->content()) --}}
<div>
        <div></div>
        <div>
            <h2>Cart</h2>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>/</li>
                <li>Cart</li>
            </ul>
        </div>
    </div>

    <section>
        <div>
            @if (Cart::instance('cart')->content()->count() == 0)
                
            
            <div id="empty-cart">
                <h2>There are no more items in your cart</h2>
                <img src="assets/images/cart.png" alt="Empty Cart">
                <p>No item found in your cart</p>
                <a href="{{ route('home') }}">Continue Browsing</a>
            </div>
            @else
    
            <div id="cart-content">
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Information</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach (Cart::instance('cart')->content() as $item)
                                
                            @php
                                $produto = Cart::instance('cart')->model($item->rowId)
                            @endphp
                            
                            <tr>
                                <td data-label="Image">
                                    <a href="{{ route('produtos.show', $produto) }}"><img src="{{ asset("storage/{$produto->imagem}") }}" alt="{{ $item->nome }}"></a>
                                </td>
                                <td data-label="Produto">
                                    <h6><a href="{{ route('produtos.show', $produto) }}">{{ $item->nome }}</a></h6>
                                    <div>
                                        <span>R${{ number_format($item->preco, 2, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="rowId" value="{{ $item->rowId }}">
                                        {{-- <input type="text" name="valor" value="R${{ number_format($item->preco, 2) }}" readonly> --}}
                                        <div>
                                            {{-- <button type="submit" onclick="updateQuantidade(this, -1)">-</button> --}}
                                            <button type="submit" name="acao" value="diminuir">-</button>
                                            <input type="number" name="quantidade" value="{{ $item->quantidade }}" readonly>
                                            {{-- <button type="submit" onclick="updateQuantidade(this, 1)">+</button> --}}
                                            <button type="submit" name="acao" value="aumentar">+</button>
                                        </div>
                                        {{-- <input type="text" name="valorTotal" value="R${{ number_format($item->subtotal, 2) }}" readonly> --}}
                                    </form>
                                </td>
                                <td>R${{ number_format($item->subtotal, 2, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item->rowId) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover esse item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"><i>Delete</i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form action="{{ route('cart.clear', $item->rowId) }}" method="POST" onsubmit="return confirm('Essa ação removerá todos os itens do seu carrinho! Tem certeza disso?')">
                        @csrf
                        @method('DELETE') 
                        <button type="submit" href="#">Limpar Carrinho</button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </section>
   <script>
        // function updateQuantidade(botao, delta) {
        //     const form = botao.closest('form');
        //     const quantidadeInput = form.querySelector('input[name="quantidade"]');
        //     let currentQuantidade = parseInt(quantidadeInput.value);
        //     if (isNaN(currentQuantidade)) currentQuantidade = 0;
        //     const newQuantidade = Math.max(1, currentQuantidade + delta);
        //     quantidadeInput.value = newQuantidade;
        // }

        // function updateQuantidade(botao, delta) {
        //     const input = botao.parentElement.querySelector('input[name="quantidade"]');
        //     input.value = Math.max(1, parseInt(input.value) + delta);
        // }
    </script>   

@endsection