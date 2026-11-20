@extends('layouts.master')

@section('content')
<h2>Pedidos</h2>

@if (session('success')) <p>{{ session('success') }}</p> @endif
@if ($errors->any())
    <ul>@foreach ($errors->all() as $erro)<li>{{ $erro }}</li>@endforeach</ul>
@endif

@forelse ($pedidos as $pedido)
    <div>
        <h3>Pedido #{{ $pedido->pedido_id }} - {{ $pedido->status_label }}</h3>
        <p>Cliente: {{ $pedido->user?->nome_usuario }} - Tel.: {{ $pedido->user?->telefone }}</p>
        <p>
            Endereço:
            {{ $pedido->endereco?->endereco_rua }}, {{ $pedido->endereco?->endereco_numero }}
            - {{ $pedido->endereco?->endereco_bairro }}
            {{ $pedido->endereco?->endereco_complemento }}
        </p>
        <p>Pagamento: {{ $pedido->forma_pagamento }} - {{ $pedido->data_pedido->format('d/m/Y H:i') }}</p>

        <ul>
            @foreach ($pedido->itens as $item)
                <li>{{ $item->quantidade }}x {{ $item->produto?->nome_produto ?? 'Produto removido' }}</li>
            @endforeach
        </ul>

        <p><strong>Total: R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</strong></p>

        @if ($pedido->status === 'em_preparo')
            <form action="{{ route('admin.pedidos.saiu', $pedido->pedido_id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit">Saiu para entrega</button>
            </form>
        @endif
    </div>
    <hr>
@empty
    <p>Nenhum pedido ainda.</p>
@endforelse
@endsection