@extends('layouts.master')

@section('content')

<h2>Cadastrar</h2>

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <label for="nome_usuario">Nome: </label>
    <input type="text" name="nome_usuario" id="nome_usuario" placeholder="Digite seu nome completo" required>

    <label for="email">E-mail: </label>
    <input type="text" name="email" id="email" placeholder="Digite seu E-mail" required>

    <label for="senha">Senha: </label>
    <input type="password" name="senha" id="senha" placeholder="Senha" required>

    <label for="telefone">Telefone: </label>
    <input type="tel" name="telefone" id="telefone" placeholder="(XX) XXXXX-XXXX">

    <label for="tipo">Tipo de conta: </label>
    <select name="tipo">
        <option value="admin">Administrador</option>
        <option value="usuario" selected>Usuário</option>
    </select>

    <h3>Endereço</h3>

    <label for="endereco_rua">Rua: </label>
    <input type="text" name="endereco_rua" id="endereco_rua" placeholder="Rua..." required>

    <label for="endereco_bairro">Bairro: </label>
    <input type="text" name="endereco_bairro" id="endereco_bairro" placeholder="Seu bairro" required>

    <label for="endereco_numero">Número: </label>
    <input type="text" name="endereco_numero" id="endereco_numero" placeholder="xxx" required>

    <label for="endereco_complemento">Complemento: </label>
    <input type="text" name="endereco_complemento" placeholder="Complemento" id="endereco_complemento">

    <button type="reset">Cancelar</button>
    <button type="submit">Cadastrar</button>

</form>
@endsection