@extends('layouts.master')

@section('content')

<a href="{{ route('produtos.create') }}">Adicionar produto</a>

<hr>

<h2>Produtos</h2>

<ul>
    @foreach ($produtos as $produto)
        <li>{{ $produto->nome_produto }} | <a href="{{ route('produtos.edit', ['produto' => $produto->produto_id]) }}">Editar</a> | <a href="{{ route('produtos.show', ['produto' => $produto->produto_id]) }}">Show</a></li>
    @endforeach
</ul>

@endsection
