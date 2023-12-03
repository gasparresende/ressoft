<?php

namespace Database\Seeders;

use App\Models\Moeda;
use Illuminate\Database\Seeder;

class MoedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            'Kwanzas',
            'Dollares',
        ];

        $sigla = [
            'Kz',
            'Usd',
        ];

        $preco = [
            1,
            661,
        ];

        $data = [
            '2021-04-14',
            '2021-04-14',
        ];

        foreach ($dados as $key =>$dado) {
            $moedas = Moeda::all()->where('moeda', $dado);
            if ($moedas->count() == 0) {
                Moeda::create([
                    'moeda' => $dado,
                    'sigla_moeda' => $sigla[$key],
                    'preco' => $preco[$key],
                    'data' => $data[$key],
                ]);
            }

        }
    }
}
