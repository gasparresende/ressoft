<?php

namespace Database\Seeders;

use App\Models\Unidade;
use Illuminate\Database\Seeder;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            'un',
            'l',
            'cx',
            'kg',
            'm',
            'g',
            'mm',
            'cm',

        ];

        foreach ($dados as $dado) {
            $unidades = Unidade::all()->where('unidade', $dado);
            if ($unidades->count() == 0) {
                Unidade::create([
                    'unidade' => $dado,
                ]);
            }

        }
    }
}
