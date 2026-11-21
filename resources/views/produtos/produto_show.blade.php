@extends('layouts.master')

@section('content')

<h2>Produtos - {{ $produto->nome_produto }}</h2>

<h3>Avaliações</h3>
@include('produtos._nota', ['produto' => $produto])

@forelse ($avaliacoes as $avaliacao)
    <div>
        <strong>{{ $avaliacao->user?->nome_usuario }}</strong>
        {{ str_repeat('★', $avaliacao->nota) }}{{ str_repeat('☆', 5 - $avaliacao->nota) }}
        - {{ $avaliacao->created_at->format('d/m/Y H:i') }}
        @if ($avaliacao->comentario)
            <p>{{ $avaliacao->comentario }}</p>
        @endif
    </div>
@empty
    <p>Este produto ainda não foi avaliado.</p>
@endforelse

<form action="{{ route('produtos.destroy', ['produto' => $produto->produto_id]) }}" method="post">
     @csrf
    {{-- <input type="hidden" name="_method" value="DELETE"> --}}
    @method('DELETE')
    <button type="submit">Exluír</button>
</form>


@endsection