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
{{-- PARTE NOVA --}}
@foreach ($produtos as $produto)
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{ asset("storage/{$produto->imagem}") }}" class="img-fluid rounded-start" alt="{{ $produto->imagem }}">
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h5 class="card-title">{{ $produto->nome_produto }}</h5>
                    <p class="card-text">{{ $produto->descricao_produto }}</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card-body">
                    <p class="card-text">{{ $produto->preco }}</p>
                    <a href="#" class="btn btn-primary">Adicionar ao carrinho</a>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- PARTE ANTIGA --}}
{{-- <ul>
    @foreach ($produtos as $produto)
        <li>{{ $produto->imagem }} | {{ $produto->nome_produto }} | {{ $produto->descricao_produto }}  | R${{ $produto->preco}} <a href="">Adicionar ao carrinho</a></li>
    @endforeach
</ul> --}}

@endsection
