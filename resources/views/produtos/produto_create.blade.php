@extends('layouts.master')

@section('content')

<h2>Registrar Produto</h2>

@if (session()->has('message'))
    {{ session()->get('message') }}
@endif

<form action="{{ route('produtos.store') }}" enctype="multipart/form-data" method="post">
    {{-- FALTA ADICIONAR A PARTE DAS CATEGORIAS --}}
    @csrf
    <label for="nome_produto">Nome do produto</label>
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
    {{-- <input type="text" name="imagem" placeholder="Imagem do produto"> --}}
    <label for="imagem">Imagem do Produto:</label>
    <input type="file" name="imagem" id="imagem">
    <label for="promocao">Promoção ativa:</label>
    <input type="checkbox" name="promocao" id="promocao" value="1" {{ old('promocao', $produto->promocao ?? false) ? 'checked' : '' }}>
    {{-- PARTE DA PROMOÇÃO --}}
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

    <label for="ativo">Produto disponível:</label>
    <input type="checkbox" name="ativo" id="ativo" value="1" checked>
    <button type="submit">Registrar</button>
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