<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
        .card { background: white; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .section-title { color: #666; border-bottom: 1px solid #eee; margin-top: 20px; }
        input, select, textarea { width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #2ecc71; color: white; border: none; padding: 10px; width: 100%; cursor: pointer; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Novo Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                </div>
        </div>
    </div>
</x-app-layout>

<div class="card">
    <h2>Novo Cadastro</h2>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf <h3 class="section-title">Dados Pessoais</h3>
        <input type="text" name="nome_usuario" placeholder="Nome do Usuário" required>
        <input type="email" name="email" placeholder="E-mail (Login)" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <input type="text" name="telefone" placeholder="Telefone">
        
        <label>Tipo de Usuário:</label>
        <select name="tipo">
            <option value="cliente">Cliente</option>
            <option value="admin">Administrador</option>
        </select>

        <h3 class="section-title">Endereço</h3>
        <input type="text" name="endereco_rua" placeholder="Rua / Logradouro" required>
        <input type="text" name="endereco_bairro" placeholder="Bairro" required>
        <input type="text" name="endereco_numero" placeholder="Número" required>
        <textarea name="endereco_complemento" placeholder="Complemento (Opcional)" rows="2"></textarea>

        <button type="submit">SALVAR CADASTRO</button>
    </form>
</div>

</body>
</html>