<?php

namespace App\Services;

// use Ramsey\Collection\Collection;
use App\Models\Carrinho;
use App\Models\Produto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class CartService
{
    protected string $instance = 'default';
    // protected ?string $lastRowId = null;

    public function instance(string $nome): self
    {
        $this->instance = $nome;
        return $this;
    }

    // ADICIONADO
    protected function definirQuantidade(int $produtoId, int $quantidade): void
    {
        if (Auth::check()) {
            $filtro = [
                'user_id' => Auth::id(),
                'produto_id' => $produtoId,
                'instance' => $this->instance,
            ];

            if ($quantidade <= 0 ) {
                Carrinho::where($filtro)->delete();
            } else {
                Carrinho::updateOrCreate($filtro, ['quantidade' => $quantidade]);
            }
            return;
        }

        $dados = Session::get("cart.{$this->instance}", []);

        if ($quantidade <= 0 ) {
            unset($dados[$produtoId]);
        } else {
            $dados[$produtoId] = $quantidade;
        }

        Session::put("cart.{$this->instance}", $dados);
    }

    // AINDA NAO VI
    protected function getCart(): Collection
    {
        $cart = Session::get("cart.{$this->instance}", collect());
        $collection = $cart instanceof Collection ? $cart : collect($cart);
        return $collection -> map(function ($item) {
            return is_array($item) ? (object) $item : $item;
        });
    }


    // ALTERADO 
    // public function add(mixed $id, ?string $nome = null, ?int $quantidade = null, ?float $preco = null, array $options = []): self
    // {
    //     if (is_array($id)){
    //         return $this->addArray($id);
    //     }

    //     $cart = $this->getCart();
    //     $rowId = md5((string)$id . serialize($options));

    //     $cartItem = (object) [
    //         'rowId' => $rowId,
    //         'id' => $id,
    //         'nome' => $nome,
    //         'quantidade' => $quantidade,
    //         'preco' => (float) $preco,
    //         'options' => $options,
    //         'subtotal' => $preco * $quantidade,
    //         'associatedModel' => null,
    //     ];

    //     $cart->put($rowId, $cartItem);
    //     $this->lastRowId = $rowId;

    //     Session::put("cart.{$this->instance}", $cart);
    //     return $this;
    // }

    public function add(int $produtoId, int $quantidade = 1): self
    {
        $atual = $this->quantidades()[$produtoId] ?? 0;
        $this->definirQuantidade($produtoId, $atual + $quantidade);
        return $this;
    }

    // RETIRADO
    // protected function addArray(array $data): self
    // {
    //     return $this->add(
    //         $data['id'],
    //         $data['nome'] ?? null,
    //         (int)($data['quantidade'] ?? 1),
    //         (float)($data['preco'] ?? 0),
    //         $data['options'] ?? [],
    //     );
    // }

    // public function associate(string $model): self
    // {
    //     if (!$this->lastRowId){
    //         return $this;
    //     }

    //     $cart = $this->getCart();
    //     $item = $cart->get($this->lastRowId);

    //     if ($item) {
    //         $item->associatedModel = $model;
    //         $cart->put($this->lastRowId, $item);
    //         Session::put("cart.{$this->instance}", $cart);
    //     }

    //     return $this;
    // }

    // ALTERADO
    public function model(string $rowId): ?Produto
    {
        // $item = $this->getCart()->get($rowId);

        // if ($item && $item->associatedModel) {
        //     return $item->associatedModel::find($item->id);
        // }

        // return null;
        return $this->get($rowId)?->model;
    }

    // ALTERADO
    // public function content(): Collection
    // {
    //     return $this->getCart();
    // }

        public function content(): Collection
    {
        $quantidades = $this->quantidades();

        if (empty($quantidades)) {
            return collect();
        }

        return Produto::whereIn('produto_id', array_keys($quantidades))
            ->get()
            ->mapWithKeys(function ($produto) use ($quantidades) {
                $quantidade = (int) $quantidades[$produto->produto_id];
                $preco = (float) $produto->preco;

                return [(string) $produto->produto_id => (object) [
                    'rowId'      => (string) $produto->produto_id,
                    'id'         => $produto->produto_id,
                    'nome'       => $produto->nome_produto,
                    'quantidade' => $quantidade,
                    'preco'      => $preco,
                    'subtotal'   => $quantidade * $preco,
                    'model'      => $produto,
                ]];
            });
    }

    // ALTERADO
    public function update(string $rowId, int $quantidade): object|bool
    {
        // $cart = $this->getCart();
        // if (!$cart->has($rowId)) return false;

        // $item = $cart->get($rowId);

        // if (is_numeric($data)) {
        //     $item->quantidade = (int)$data;
        // } else {
        //     foreach ($data as $key => $value) {
        //         $item->{$key} = $value;
        //     }
        // }

        // if ($item->quantidade <= 0) {
        //     $this->remove($rowId);
        //     return $item;
        // }

        // $item->preco = (float) $item->preco;
        // $item->subtotal = $item->quantidade * $item->preco;
        // Session::put("cart.{$this->instance}", $cart);
        // return $item; 
        if (!array_key_exists((int) $rowId, $this->quantidades())) {
            return false;
        }

        $this->definirQuantidade((int) $rowId, $quantidade);
        return true;
    }


    // ALTERADO 
    public function remove(string $rowId): void
    {
        // $cart = $this->getCart();
        // $cart->forget($rowId);
        // Session::put("cart.{$this->instance}", $cart);
        $this->definirQuantidade((int) $rowId, 0);
    }


    // ALTERADO
    public function destroy(): void
    {
        if (Auth::check()) {
            Carrinho::where('user_id', Auth::id())
                ->where('instance', $this->instance)
                ->delete();
        } else {
            Session::forget("cart.{$this->instance}");
        }
    }


    // ALTERADO
    public function total(): float
    {
        // return (float) $this->getCart()->sum('subtotal');
        return (float) $this->content()->sum('subtotal');
    }

    // ALTERADO 
    public function count(): int
    {
        return (int) $this->content()->sum('quantidade');
        // getCart
    }

    public function get(string $rowId): ?object
    {
        return $this->content()->get($rowId);
    }

    protected function quantidades(): array
    {   
        if (Auth::check()) {
            return Carrinho::where('user_id', Auth::id())
                ->where('instance', $this->instance)
                ->pluck('quantidade', 'produto_id')
                ->all();
        }

        return Session::get("cart.{$this->instance}", []);
    }

     public function mergeGuestCart(): void
    {
        if (!Auth::check()) {
            return;
        }

        $visitante = Session::pull("cart.{$this->instance}", []);

        foreach ($visitante as $produtoId => $quantidade) {
            $this->add((int) $produtoId, (int) $quantidade);
        }
    }
}
