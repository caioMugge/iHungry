@extends('layouts.master')

@section('content')

<h2>{{ $produto->nome_produto }}</h2>

<img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome_produto }}" width="200">
<p>{{ $produto->descricao_produto }}</p>
<p>R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>

<form action="{{ route('cart.add') }}" method="POST">
    @csrf
    <input type="hidden" name="produto_id" value="{{ $produto->produto_id }}">
    <input type="number" name="quantidade" value="1" min="1">
    <button type="submit">Adicionar ao carrinho</button>
</form>

<a href="{{ route('home') }}">Voltar</a>

@endsection