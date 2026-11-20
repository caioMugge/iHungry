@extends('layouts.master')

@section('content')
<h2>Pedido realizado com sucesso!</h2>
<p>Forma de pagamento: {{ $resumo['metodo'] }}</p>
<p>Total: R$ {{ number_format($resumo['total'], 2, ',', '.') }}</p>
<a href="{{ route('home') }}">Voltar para a home</a>
<a href="{{ route('pedidos.show', $resumo['pedido_id']) }}">Acompanhar pedido</a>
@endsection