<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            'Azul',
            'Vermelho',
            'Verde',
            'Preto',
            'Amarelo',
            'Branco',
            'Rosa',
            'Laranja',
            'Roxo',
            'Cinza',
            'Marrom',
        ];

        foreach ($dados as $key => $dado) {
            $color = Color::create([
                'color' => $dado,
            ]);
        }
    }
}
