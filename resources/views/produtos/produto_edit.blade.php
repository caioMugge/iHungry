@extends('layouts.master')

@section('content')

<h2>Editar Produto</h2>

@if (session()->has('message'))
    {{ session()->get('message') }}
@endif

<form action="{{ route('produtos.update', ['produto' => $produto->produto_id]) }}" enctype="multipart/form-data" method="post">
    {{-- FALTA ADICIONAR A PARTE DAS CATEGORIAS --}}
    @csrf
    {{-- <input type="hidden" name="_method" value="PUT"> --}}
    @method('PUT')
    <label for="nome_produto">Nome do produto</label>
    <input type="text" name="nome_produto" value="{{ $produto->nome_produto }}">
    <label for="descricao_produto">Descrição do produto</label>
    <textarea name="descricao_produto">{{ $produto->descricao_produto }}</textarea>
    <label for="preco">preço do produto</label>
    <input type="number" name="preco" step="0.01" min="0" value="{{ $produto->preco }}">
    {{-- <input type="text" name="imagem" value="{{ $produto->imagem }}"> --}}
    <label for="imagem">Imagem do Produto:</label>
    <input type="file" name="imagem" id="imagem">
    <label for="promocao">Descrição do produto</label>
    <input type="checkbox" name="promocao" value="1" {{ $produto->promocao ? 'checked' : '' }}>
    <label for="ativo">Descrição do produto</label>
    <input type="checkbox" name="ativo" value="1" {{ $produto->ativo ? 'checked' : '' }}>
    <button type="submit">Editar</button>
</form>

@endsection