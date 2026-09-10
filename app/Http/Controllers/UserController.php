<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use User;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);

        // VALIDAÇÃO
        $request->validate([
            'nome_usuario' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'senha' => 'required|min:6',
            'endereco_rua' => 'required',
            'endereco_bairro' => 'required',
            'endereco_numero' => 'required',
        ]);

        try {
            DB::transaction(function () use($request) {
                $endereco = Endereco::create([
                    'endereco_rua' => $request->endereco_rua,
                    'endereco_bairro' => $request->endereco_bairro,
                    'endereco_numero' => $request->endereco_numero,
                    'endereco_complemento' => $request->endereco_complemento,
                ]);
                User::create([
                    'id_endereco' => $endereco->id_endereco,
                    'nome_usuario' => $request->nome_usuario,
                    'email' => $request->email,
                    'senha' => Hash::make($request->senha),
                    'telefone' => $request->telefone,
                    'tipo' => $request->tipo,
                ]);
            });
            return redirect()->route('home')->with('success', 'Usuário cadastrado com sucesso!');
        } catch(\Illuminate\Database\QueryException $e) {
            return back()->withErrors(['erro' => 'Erro ao cadastrar usuário.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
