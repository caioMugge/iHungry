<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\Usuario;
// use App\Models\Endereco;

class UsuarioController extends Controller
{
    public function index()
    {
        // carregar a VIEW
        return view('users.index');
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(UsuarioRequest $request)
    {
        // validar formulario
        $request->validated();

        Usuario::create([
            'nome_usuario' => $request->nome_usuario,
            'email' => $request->email,
            'senha' => $request->senha,
            'telefone' => $request->telefone,
            'tipo' => $request->tipo,
        ]);

        return redirect()->route('user.index')->with('success', 'Usuário cadastrado com sucesso!');
    }
}
