<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // /**
    //  * Run the migrations.
    //  */
    // public function up(): void
    // {
    //     Schema::create('avaliacoes', function (Blueprint $table) {
    //         $table->id('avaliacao_id');
    //         $table->foreignId('user_id')
    //             ->constrained('users', 'user_id')
    //             ->cascadeOnDelete();
    //         $table->foreignId('produto_id')
    //             ->constrained('produtos', 'produto_id')
    //             ->cascadeOnDelete();
    //         $table->unsignedTinyInteger('nota');
    //         $table->text('comentario');
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('avaliacoes');
    // }

    public function up(): void
    {
        Schema::table('avaliacoes', function (Blueprint $table) {
            $table->foreignId('item_id')
                ->nullable()
                ->after('avaliacao_id')
                ->unique()
                ->constrained('item_pedidos', 'item_id')
                ->cascadeOnDelete();

            $table->text('comentario')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('avaliacoes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('item_id');
        });
    }
};
