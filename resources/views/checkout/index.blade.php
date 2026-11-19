@extends('layouts.master')

@section('content')
<h2>Finalizar compra</h2>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $erro)
            <li>{{ $erro }}</li>
        @endforeach
    </ul>
@endif

<h3>Resumo</h3>
<ul>
    @foreach ($itens as $item)
        <li>{{ $item->quantidade }}x {{ $item->nome }} - R$ {{ number_format($item->subtotal, 2, ',', '.') }}</li>
    @endforeach
</ul>
<p><strong>Total: R$ {{ number_format($total, 2, ',', '.') }}</strong></p>

<h3>Forma de pagamento</h3>
<form action="{{ route('checkout.escolher') }}" method="POST">
    @csrf
    @foreach ($metodos as $valor => $nome)
        <label>
            <input type="radio" name="metodo" value="{{ $valor }}" {{ old('metodo') == $valor ? 'checked' : '' }} required>
            {{ $nome }}
        </label><br>
    @endforeach

    <button type="submit">Continuar</button>
</form>

<a href="{{ route('cart.index') }}">Voltar ao carrinho</a>
@endsection