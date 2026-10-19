<?php

namespace App\Services;

// use Ramsey\Collection\Collection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;


class CartService
{
    protected string $instance = 'default';
    protected ?string $lastRowId = null;

    public function instance(string $nome): self
    {
        $this->instance = $nome;
        return $this;
    }


    protected function getCart(): Collection
    {
        $cart = Session::get("cart.{$this->instance}", collect());
        $collection = $cart instanceof Collection ? $cart : collect($cart);
        return $collection -> map(function ($item) {
            return is_array($item) ? (object) $item : $item;
        });
    }

    public function add(mixed $id, ?string $nome = null, ?int $quantidade = null, ?float $preco = null, array $options = []): self
    {
        if (is_array($id)){
            return $this->addArray($id);
        }

        $cart = $this->getCart();
        $rowId = md5((string)$id . serialize($options));

        $cartItem = (object) [
            'rowId' => $rowId,
            'id' => $id,
            'nome' => $nome,
            'quantidade' => $quantidade,
            'preco' => (float) $preco,
            'options' => $options,
            'subtotal' => $preco * $quantidade,
            'associatedModel' => null,
        ];

        $cart->put($rowId, $cartItem);
        $this->lastRowId = $rowId;

        Session::put("cart.{$this->instance}", $cart);
        return $this;
    }

    protected function addArray(array $data): self
    {
        return $this->add(
            $data['id'],
            $data['nome'] ?? null,
            (int)($data['quantidade'] ?? 1),
            (float)($data['preco'] ?? 0),
            $data['options'] ?? [],
        );
    }

    public function associate(string $model): self
    {
        if (!$this->lastRowId){
            return $this;
        }

        $cart = $this->getCart();
        $item = $cart->get($this->lastRowId);

        if ($item) {
            $item->associatedModel = $model;
            $cart->put($this->lastRowId, $item);
            Session::put("cart.{$this->instance}", $cart);
        }

        return $this;
    }

    public function model(string $rowId): ?object
    {
        $item = $this->getCart()->get($rowId);

        if ($item && $item->associatedModel) {
            return $item->associatedModel::find($item->id);
        }

        return null;
    }

    public function content(): Collection
    {
        return $this->getCart();
    }

    public function update(string $rowId, mixed $data): object|bool
    {
        $cart = $this->getCart();
        if (!$cart->has($rowId)) return false;

        $item = $cart->get($rowId);

        if (is_numeric($data)) {
            $item->quantidade = (int)$data;
        } else {
            foreach ($data as $key => $value) {
                $item->{$key} = $value;
            }
        }

        if ($item->quantidade <= 0) {
            $this->remove($rowId);
            return $item;
        }

        $item->preco = (float) $item->preco;
        $item->subtotal = $item->quantidade * $item->preco;
        Session::put("cart.{$this->instance}", $cart);
        return $item; 
    }

    public function remove(string $rowId): void
    {
        $cart = $this->getCart();
        $cart->forget($rowId);
        Session::put("cart.{$this->instance}", $cart);
    }

    public function destroy(): void
    {
        Session::forget("cart.{$this->instance}");
    }

    public function total(): float
    {
        return (float) $this->getCart()->sum('subtotal');
    }

    public function count(): int
    {
        return (int) $this->getCart()->sum('quantidade');
    }
}
