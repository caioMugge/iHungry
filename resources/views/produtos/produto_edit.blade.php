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
    <label for="promocao">Produto em promoção</label>
    {{-- <input type="checkbox" name="promocao" value="1" {{ $produto->promocao ? 'checked' : '' }}> --}}
    <input type="checkbox" name="promocao" id="promocao" value="1" {{ old('promocao', $produto->promocao ?? false) ? 'checked' : '' }}>
    {{-- PROMOÇÃO --}}
    <div id="campos-promocao" hidden>
        <label>
        <input type="radio" name="tipo_desconto" value="porcentagem"
            {{ old('tipo_desconto') === 'porcentagem' ? 'checked' : '' }}>
        Porcentagem (%)
    </label>
    <label>
        <input type="radio" name="tipo_desconto" value="valor"
            {{ old('tipo_desconto', 'valor') === 'valor' ? 'checked' : '' }}>
        Novo valor (R$)
    </label>

    <input type="number" name="desconto" step="0.01" min="0"
        value="{{ old('desconto', $produto->preco_promocional ?? '') }}">
    </div>

    <label for="ativo">Produto ativo</label>
    <input type="checkbox" name="ativo" value="1" {{ $produto->ativo ? 'checked' : '' }}>
    <button type="submit">Editar</button>
</form>

<script>
    const chkPromocao = document.getElementById('promocao');
    const camposPromocao = document.getElementById('campos-promocao');

    function alternarPromocao() {
        camposPromocao.hidden = !chkPromocao.checked;
    }

    chkPromocao.addEventListener('change', alternarPromocao);
    alternarPromocao();
</script>

@endsection