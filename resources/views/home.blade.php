@extends('layouts.master')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif


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

        <a href="{{ route('cart.index') }}">
            <i></i>
            <span>
                {{ Cart::instance('cart')->count() }}
            </span> Itens no carrinho
        </a>
    @endauth
</header>

<hr>

<h1>Home</h1>

<h2>Confira nossos Produtos</h2>
{{-- PARTE NOVA --}}
@foreach ($produtos as $produto)
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-2">
                <img src="{{ asset("storage/{$produto->imagem}") }}" class="img-fluid rounded-start" alt="{{ $produto->imagem }}">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $produto->nome_produto }}</h5>
                    <p class="card-text">{{ $produto->descricao_produto }}</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card-body">
                    <p class="card-text">{{ $produto->preco }}</p>

                    {{-- NOVO --}}
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produto_id" value="{{ $produto->produto_id }}">
                        <div>
                            <button type="button" onclick="updateQuantidade(this, -1)">-</button>
                            <input type="number" name="quantidade" value="1" min="1" readonly>
                            <button type="button" onclick="updateQuantidade(this, 1)">+</button>
                        </div>

                        <button type="submit" class="btn btn-primary">Adicionar ao carrinho</button>
                    </form>
                    {{-- ANTIGO --}}

                    {{-- <a href="#" class="btn btn-primary">Adicionar ao carrinho</a> --}}
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


<script>
    function updateQuantidade(botao, delta) {
        const input = botao.parentElement.querySelector('input[name="quantidade"]');
        input.value = Math.max(1, parseInt(input.value) + delta);
    }
</script>   
@endsection
