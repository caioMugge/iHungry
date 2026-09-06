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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('pedido_id');
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->cascadeOnDelete();
            $table->foreignId('endereco_id')
                ->constrained('endereco', 'endereco_id')
                ->cascadeOnDelete();
            $table->dateTime('data_pedido');
            $table->string('status', 150);
            $table->decimal('valor_total', total: 10, places: 2);
            $table->string('forma_pagamento', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
