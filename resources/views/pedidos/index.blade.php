@extends('layouts.master')

@section('content')
<h2>Meus pedidos</h2>

@forelse ($pedidos as $pedido)
    <p>
        Pedido #{{ $pedido->pedido_id }} -
        {{ $pedido->data_pedido->format('d/m/Y H:i') }} -
        R$ {{ number_format($pedido->valor_total, 2, ',', '.') }} -
        {{ $pedido->status_label }}
        <a href="{{ route('pedidos.show', $pedido->pedido_id) }}">Acompanhar</a>
    </p>
@empty
    <p>Você ainda não fez nenhum pedido.</p>
@endforelse
@endsection