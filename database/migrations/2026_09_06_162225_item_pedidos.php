<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_pedidos', function (Blueprint $table) {
            $table->id('item_id');
            $table->foreignId('pedido_id')
                ->constrained('pedidos', 'pedido_id')
                ->cascadeOnDelete();
            $table->foreignId('produto_id')
                ->constrained('produtos', 'produto_id')
                ->cascadeOnDelete();
            $table->integer('quantidade');
            $table->decimal('preco_unitario', total: 10, places: 2);
            $table->decimal('subtotal', total: 10, places: 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pedidos');
    }
};
