<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            'Entradas',
            'Sobremesas',
            'Pratos',
            'Bebidas',
        ];

        foreach ($dados as $key => $dado) {
            $categoria = Categoria::create([
                'categoria' => $dado,
            ]);
        }
    }
}
