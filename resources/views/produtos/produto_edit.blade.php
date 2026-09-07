@extends('layouts.master')

@section('content')

<h2>Editar Produto</h2>

@if (session()->has('message'))
    {{ session()->get('message') }}
@endif

<form action="{{ route('produtos.update', ['produto' => $produto->produto_id]) }}" method="post">
    {{-- FALTA ADICIONAR A PARTE DAS CATEGORIAS --}}
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <input type="text" name="nome_produto" value="{{ $produto->nome_produto }}">
    <textarea name="descricao_produto">{{ $produto->descricao_produto }}</textarea>
    <input type="number" name="preco" step="0.01" min="0" value="{{ $produto->preco }}">
    <input type="text" name="imagem" value="{{ $produto->imagem }}">
    <input type="checkbox" name="promocao" value="1" {{ $produto->promocao ? 'checked' : '' }}>
    <input type="checkbox" name="ativo" value="1" {{ $produto->ativo ? 'checked' : '' }}>
    <button type="submit">Editar</button>
</form>

@endsection