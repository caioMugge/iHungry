@extends('layouts.master')
@section('content')

@if ($errors->any())
    <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
@endif

<form action="{{ route('login.store') }}" method="POST">
    @csrf
    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" required>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required>

    <button type="submit">Entrar</button>
</form>

@endsection