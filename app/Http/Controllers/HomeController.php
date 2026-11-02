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
        // $produtos = Produto::all();
        // return view('home', compact('produtos'));

        $categorias = Categoria::all();
        $produtos = Produto::query()->when($request->filled('categoria'), function ($query) use ($request){
            $query->where('categoria_id', $request->categoria);
        })->get();

        return view('home', compact('produtos', 'categorias'));
    }
}
