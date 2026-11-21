<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
