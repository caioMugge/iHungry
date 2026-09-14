@extends('layouts.master')

@section('content')

<h2>Cadastrar categoria</h2>

@if (session()->has('message'))
    {{ session()->get('message') }}
@endif

<form action="{{ route('categorias.store') }}" method="POST">
    @csrf
    <label for="nome_categoria">categoria: </label>
    <input type="text" name="nome_categoria" id="nome_categoria" placeholder="Categoria" required>

    <label for="descricao_categoria">Descrição: </label>
    <textarea name="descricao_categoria" placeholder="Descrição do categoria"></textarea>

    <button type="reset">Cancelar</button>
    <button type="submit">Cadastrar</button>

</form>

@endsection
