@extends('layouts.master')

@section('content')
<h2>Pagamento: {{ $metodoNome }}</h2>
<p>Total: R$ {{ number_format($total, 2, ',', '.') }}</p>

@switch($metodo)
    @case('dinheiro')
        <p>Pague em dinheiro ao receber o pedido.</p>
        @break

    @case('cartao_debito')
    @case('cartao_credito')
        <p>Pagamento simulado no cartão. Nenhum dado de cartão é solicitado ou armazenado.</p>
        @break

    @case('qrcode')
        <p>Escaneie o QR Code abaixo (simulado):</p>
        <div>[ QR CODE SIMULADO ]</div>
        @break
@endswitch

<form action="{{ route('checkout.confirmar') }}" method="POST">
    @csrf
    <button type="submit">Confirmar pagamento</button>
</form>

<a href="{{ route('checkout.index') }}">Trocar forma de pagamento</a>
@endsection