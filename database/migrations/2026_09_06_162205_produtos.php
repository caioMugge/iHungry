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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id('produto_id');
            $table->foreignId('categoria_id')
                ->constrained('categorias', 'categoria_id')
                ->cascadeOnDelete();
            $table->string('nome_produto', 120);
            $table->text('descricao_produto');
            $table->decimal('preco', total: 10, places: 2);
            $table->string('imagem', 255);
            $table->boolean('promocao');
            $table->boolean('ativo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
