@extends('layouts.master')

@section('content')

<h2>Registrar Produto</h2>

@if (session()->has('message'))
    {{ session()->get('message') }}
@endif

<form action="{{ route('produtos.store') }}" method="post">
    {{-- FALTA ADICIONAR A PARTE DAS CATEGORIAS --}}
    @csrf
    <input type="text" name="nome_produto" placeholder="Nome do produto">
    <label for="categoria_id">Categoria:</label>
    <select name="categoria_id" id="categoria_id">
        <option value="">Selecione uma categoria</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->categoria_id }}">
                {{ $categoria->nome_categoria }}
            </option>
        @endforeach
    </select>
    <textarea name="descricao_produto" placeholder="Descrição do produto"></textarea>
    <input type="number" name="preco" step="0.01" min="0" placeholder="Preço">
    <input type="text" name="imagem" placeholder="Imagem do produto">
    <label for="promocao">Promoção ativa:</label>
    <input type="checkbox" name="promocao">
    <label for="ativo">Produto disponível:</label>
    <input type="checkbox" name="ativo">
    <button type="submit">Registrar</button>
</form>

@endsection