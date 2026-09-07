@extends('layouts.master')

@section('content')

<h2>Produtos - {{ $produto->nome_produto }}</h2>

<form action="{{ route('produtos.destroy', ['produto' => $produto->produto_id]) }}" method="post">
     @csrf
    <input type="hidden" name="_method" value="DELETE">
    <button type="submit">Exluír</button>
</form>


@endsection