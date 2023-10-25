<?php

namespace Database\Seeders;

use App\Models\Taxa;
use Illuminate\Database\Seeder;

class TaxaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            0 => 'Isento',
            2 => 'Taxa reduzida',
            5 => 'Taxa Intermediaria',
            14 => 'Taxa Normal'
        ];

        foreach ($dados as $key => $dado) {
            $taxas = Taxa::all()->where('taxa', $dado);
            if ($taxas->count() == 0) {
                Taxa::create([
                    'taxa' => $key,
                    'obs' => $dado,
                ]);
            }

        }
    }
}
