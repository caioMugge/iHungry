<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use App\Models\Categoria;

class ProdutoController extends Controller
{
    public readonly Produto $produto;
    public function __construct()
    {
        $this->produto = new Produto();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = $this->produto->all();
        return view('produtos.produtos', ['produtos' => $produtos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('produtos.produto_create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'promocao' => $request->has('promocao'),
            'ativo' => $request->has('ativo'),
        ]);

        $created = $this->produto->create([
                'nome_produto' => $request->input('nome_produto'),
                'categoria_id' => $request->input('categoria_id'),
                'descricao_produto' => $request->input('descricao_produto'),
                'preco' => $request->input('preco'),
                'imagem' => $request->input('imagem'),
                'promocao' => $request->input('promocao'),
                'ativo' => $request->input('ativo'),
            ]
        );

        if ($created) {
            return redirect()->back()->with('message', 'Cadastro de produto concluído!');
        }
        return redirect()->back()->with('message', 'Cadastro de produto falhou!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        return view('produtos.produto_show', ['produto' => $produto]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        return view('produtos.produto_edit', ['produto' => $produto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->merge([
            'promocao' => $request->has('promocao'),
            'ativo' => $request->has('ativo'),
        ]);

        $updated = $this->produto->where('produto_id', $id)->update($request->except(['_token', '_method']));
        
        if ($updated) {
            return redirect()->back()->with('message', 'Atualização concluída!');
        }
        return redirect()->back()->with('message', 'Atualização falhou!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->produto->where('produto_id', $id)->delete();

        return redirect()->route('produtos.index');
    }
}
