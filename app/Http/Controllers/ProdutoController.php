<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
        
         $regrasDesconto = [];

        if ($request->has('promocao')) {
            $regrasDesconto = [
                'tipo_desconto' => 'required|in:porcentagem,valor',
                'desconto'      => $request->input('tipo_desconto') === 'porcentagem'
                    ? 'required|numeric|min:1|max:99'
                    : 'required|numeric|gt:0|lt:preco',
            ];
        }

        $request->validate(array_merge([
            'nome_produto'      => 'required|string|max:150',
            'categoria_id'      => 'required|integer',
            'descricao_produto' => 'nullable|string',
            'preco'             => 'required|numeric|min:0',
            'imagem'            => 'required|image|max:2048',
        ], $regrasDesconto));

        $file_name = rand(0, 999999) . "-" . $request->file('imagem')->getClientOriginalName();
        $path = $request->file('imagem')->storeAs('uploads', $file_name, 'public');

        $created = $this->produto->create([
                'nome_produto' => $request->input('nome_produto'),
                'categoria_id' => $request->input('categoria_id'),
                'descricao_produto' => $request->input('descricao_produto'),
                'preco' => $request->input('preco'),
                'imagem' => $path,
                'promocao' => $request->has('promocao'),
                'ativo' => $request->has('ativo'),
                'preco_promocional' => $this->calcularPrecoPromocional($request),   
            ]
        );

        if ($created) {
            return redirect()->back()->with('message', 'Cadastro de produto concluído!');
        }
        return redirect()->back()->with('message', 'Cadastro de produto falhou!');
            // PARTE ANTIGA
        // $request->merge([
        //     'promocao' => $request->has('promocao'),
        //     'ativo' => $request->has('ativo'),
        // ]);

        // $file_name = rand(0, 999999) . "-" . $request->file('imagem')->getClientOriginalName();
        // $path = $request->file('imagem')->storeAs('uploads', $file_name, 'public');

        // $created = $this->produto->create([
        //         'nome_produto' => $request->input('nome_produto'),
        //         'categoria_id' => $request->input('categoria_id'),
        //         'descricao_produto' => $request->input('descricao_produto'),
        //         'preco' => $request->input('preco'),
        //         'imagem' => $path,
        //         'promocao' => $request->input('promocao'),
        //         'ativo' => $request->input('ativo'),
        //     ]
        // );

        // if ($created) {
        //     return redirect()->back()->with('message', 'Cadastro de produto concluído!');
        // }
        // return redirect()->back()->with('message', 'Cadastro de produto falhou!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        // return view('produtos.produto_show', ['produto' => $produto]);
        $admin = Auth::check() && Auth::user()->tipo === 'admin';

        if ($admin) {
            return view('produtos.produto_show', ['produto' => $produto]);
        }

        // cliente não vê produto desativado
        abort_if(!$produto->ativo, 404);

        return view('produtos.produto_detalhe', ['produto' => $produto]);
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

    //PARTE FORA
        // $request->merge([
        //     'promocao' => $request->has('promocao'),
        //     'ativo' => $request->has('ativo'),
        // ]);

        // $updated = $this->produto->where('produto_id', $id)->update($request->except(['_token', '_method']));
        
        // if ($updated) {
        //     return redirect()->back()->with('message', 'Atualização concluída!');
        // }
        // return redirect()->back()->with('message', 'Atualização falhou!');

        $regrasDesconto = [];

        if ($request->has('promocao')) {
            $regrasDesconto = [
                'tipo_desconto' => 'required|in:porcentagem,valor',
                'desconto'      => $request->input('tipo_desconto') === 'porcentagem'
                    ? 'required|numeric|min:1|max:99'
                    : 'required|numeric|gt:0|lt:preco',
            ];
        }

        $request->validate(array_merge([
            'nome_produto'      => 'required|string',
            // 'categoria_id'      => 'required|integer',
            'descricao_produto' => 'nullable|string',
            'preco'             => 'required|numeric|min:0',
            'imagem'            => 'nullable|image|max:2048',
        ], $regrasDesconto));

        $produto = $this->produto->findOrFail($id);

        $path = [
            'nome_produto'      => $request->input('nome_produto'),
            // 'categoria_id'      => $request->input('categoria_id'),
            'descricao_produto' => $request->input('descricao_produto'),
            'preco'             => $request->input('preco'),
            'promocao'          => $request->has('promocao'),
            'ativo'             => $request->has('ativo'),
            'preco_promocional' => $this->calcularPrecoPromocional($request),
        ];

        if ($request->hasFile('imagem')) {
        // apaga a imagem antiga, se existir
            if ($produto->imagem) {
                Storage::disk('public')->delete($produto->imagem);
            }

            $file_name = rand(0, 999999) . '-' . $request->file('imagem')->getClientOriginalName();
            $path['imagem'] = $request->file('imagem')->storeAs('uploads', $file_name, 'public');
        }

        $produto->update($path);

        return redirect()->back()->with('message', 'Atualização concluída!');

        // PARTE ANTIGA

        // $request->validate([
        //     'nome_produto'      => 'required|string',
        //     // 'categoria_id'      => 'required|integer',
        //     'descricao_produto' => 'nullable|string',
        //     'preco'             => 'required|numeric|min:0',
        //     'imagem'            => 'nullable|image|max:2048',
        // ]);

        // $produto = $this->produto->findOrFail($id);

        // $path = [
        //     'nome_produto'      => $request->input('nome_produto'),
        //     // 'categoria_id'      => $request->input('categoria_id'),
        //     'descricao_produto' => $request->input('descricao_produto'),
        //     'preco'             => $request->input('preco'),
        //     'promocao'          => $request->has('promocao'),
        //     'ativo'             => $request->has('ativo'),
        // ];

        // if ($request->hasFile('imagem')) {
        // // apaga a imagem antiga, se existir
        //     if ($produto->imagem) {
        //         Storage::disk('public')->delete($produto->imagem);
        //     }

        //     $file_name = rand(0, 999999) . '-' . $request->file('imagem')->getClientOriginalName();
        //     $path['imagem'] = $request->file('imagem')->storeAs('uploads', $file_name, 'public');
        // }

        // $produto->update($path);

        // return redirect()->back()->with('message', 'Atualização concluída!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->produto->where('produto_id', $id)->delete();

        return redirect()->route('produtos.index');
    }

    private function calcularPrecoPromocional(Request $request): ?float
    {
        if (!$request->has('promocao')) {
            return null;
        }

        $preco    = (float) $request->input('preco');
        $desconto = (float) $request->input('desconto');

        $final = $request->input('tipo_desconto') === 'porcentagem'
            ? $preco * (1 - $desconto / 100)
            : $desconto;

        return round($final, 2);
    }
}
