@extends('layouts.master')

@section('content')
<h2>Pedido #{{ $pedido->pedido_id }}</h2>

@if (session('success')) <p>{{ session('success') }}</p> @endif
@if ($errors->any())
    <ul>@foreach ($errors->all() as $erro)<li>{{ $erro }}</li>@endforeach</ul>
@endif

<h3>Status</h3>
<ol>
    <li>{{ $pedido->status === 'em_preparo' ? '➡️' : '✅' }} Pedido em preparo</li>
    <li>
        {{ $pedido->status === 'saiu_para_entrega' ? '➡️' : ($pedido->status === 'entregue' ? '✅' : '⏳') }}
        Saiu para entrega
    </li>
    <li>{{ $pedido->status === 'entregue' ? '✅' : '⏳' }} Entregue</li>
</ol>

@if ($pedido->status === 'saiu_para_entrega')
    <form action="{{ route('pedidos.entregue', $pedido->pedido_id) }}" method="POST"
          onsubmit="return confirm('Confirmar que você recebeu o pedido?')">
        @csrf
        @method('PATCH')
        <button type="submit">Recebi meu pedido</button>
    </form>
@endif

<h3>Itens</h3>
<ul>
    @foreach ($pedido->itens as $item)
        <li>
            {{ $item->quantidade }}x {{ $item->produto?->nome_produto ?? 'Produto removido' }}
            - R$ {{ number_format($item->subtotal, 2, ',', '.') }}

            {{-- avaliação --}}
            @if ($pedido->status === 'entregue')
                @if ($item->avaliacao)
                    <p>
                        Sua avaliação:
                        {{ str_repeat('★', $item->avaliacao->nota) }}{{ str_repeat('☆', 5 - $item->avaliacao->nota) }}
                    </p>
                    @if ($item->avaliacao->comentario)
                        <p>"{{ $item->avaliacao->comentario }}"</p>
                    @endif
                @else
                    <form action="{{ route('avaliacoes.store', $item->item_id) }}" method="POST">
                        @csrf
                        <p>Avalie este produto:</p>
                        @for ($n = 1; $n <= 5; $n++)
                            <label>
                                <input type="radio" name="nota" value="{{ $n }}" required>
                                {{ $n }} ★
                            </label>
                        @endfor
                        <br>
                        <textarea name="comentario" maxlength="500" placeholder="Comentário (opcional)"></textarea>
                        <button type="submit">Enviar avaliação</button>
                    </form>
                @endif
            @endif
        </li>
    @endforeach
</ul>

<p>Pagamento: {{ $pedido->forma_pagamento }}</p>
<p><strong>Total: R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</strong></p>

<a href="{{ route('pedidos.index') }}">Voltar para meus pedidos</a>
@endsection