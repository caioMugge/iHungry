<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;

// use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $admin = $request->user()?->isAdmin() ?? false;
        // $produtos = Produto::all();
        // return view('home', compact('produtos'));

        // filtro "Inativos": só vale para o admin
        $soInativos = $admin && $request->query('filtro') === 'inativos';

        // o link "Inativos" só aparece para o admin e se existir algum produto inativo
        $temInativos = $admin && Produto::where('ativo', false)->exists();

        $categorias = Categoria::all();
        $produtos = Produto::query()->where('ativo', !$soInativos)
        ->withAvg('avaliacoes', 'nota')
        ->withCount('avaliacoes')
        ->when($request->filled('categoria'), function ($query) use ($request){
            $query->where('categoria_id', $request->categoria);
        })->get();

        return view('home', compact('produtos', 'categorias', 'temInativos', 'soInativos'));
    }
}
