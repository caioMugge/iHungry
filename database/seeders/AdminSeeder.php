<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Endereco;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $endereco = Endereco::create([
            'endereco_rua' => 'Rua Admin',
            'endereco_bairro' => 'Centro',
            'endereco_numero' => '0',
            'endereco_complemento' => 'Casa',
        ]);

        User::create([
        'endereco_id' => $endereco->endereco_id,
        'nome_usuario' => 'Administrador',
        'email' => 'admin@admin.com',
        'senha' => Hash::make('administrador'),
        'telefone' => '00000000000',
        'tipo' => 'admin',
        ]);
    }
}
