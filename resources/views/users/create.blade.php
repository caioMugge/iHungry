<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iHungry</title>
</head>
<body>
    <a href="{{ route('user.index') }}">Listar</a>

    <!-- verificando erros -->
    <h2>Cadastro de Usuário</h2>
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color: #f00;">
                {{ $error }}
            </p>
        @endforeach
    @endif

    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        @method('POST')

        <div class="usuario">
            <label for="nome_usuario">Nome: </label>
            <input type="text" id="nome_usuario" name="nome_usuario" placeholder="Seu nome" value="{{ old('nome_usuario') }}"><br>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"><br>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" value="{{ old('senha') }}"><br>

            <label for="telefone">Telefone: </label>
            <input type="text" name="telefone" id="telefone"><br>

            <label for="tipo">Tipo: </label>
            <select name="tipo" id="tipo">
                <option value="admin">Adminstrador</option>
                <option value="usuario">Usuário</option>
            </select><br>
        </div>


        <div class="endereco">
            <label for="endereco_rua">Rua: </label>
            <input type="text" name="endereco_rua" id="endereco_rua"><br>

            <label for="endereco_bairro">Bairro: </label>
            <input type="text" name="endereco_bairro" id="endereco_bairro"><br>

            <label for="endereco_numero">Número: </label>
            <input type="number" name="endereco_numero" id="endereco_numero"><br>

            <label for="endereco_complemento">Complemento: </label>
            <input type="text" name="endereco_complemento" id="endereco_complemento"><br>
        </div>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>