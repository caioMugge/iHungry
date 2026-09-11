@extends('layouts.master')

@section('content')


<header>
    @guest
        <a href="{{ route('users.create') }}">Cadastrar</a>
        <a href="{{ route('login') }}">Login</a>
    @endguest

    @auth
        <span>Olá, {{ auth()->user()->nome_usuario }}</span>

        @if(auth()->user()->tipo === 'admin')
            <a href="{{ route('produtos.index') }}">Listar Produtos - específico</a>
        @endif

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Sair</button>
        </form>
    @endauth
</header>

<hr>

<h1>Home</h1>

<h2>Confira nossos Produtos</h2>

<ul>
    @foreach ($produtos as $produto)
        <li>{{ $produto->imagem }} | {{ $produto->nome_produto }} | {{ $produto->descricao_produto }}  | R${{ $produto->preco}} <a href="">Adicionar ao carrinho</a></li>
    @endforeach
</ul>

@endsection
