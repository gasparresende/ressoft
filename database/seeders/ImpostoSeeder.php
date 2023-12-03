<?php

namespace Database\Seeders;

use App\Models\Imposto;
use Illuminate\Database\Seeder;

class ImpostoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $dados = [
            'Retenção na Fonte',
            'IAC',
            'IPU'
        ];

        $dados2 = [
            6.5,
            10,
            15
        ];

        foreach ($dados as $key => $dado) {
            $impostos = Imposto::all()->where('imposto', $dado);
            if ($impostos->count() == 0) {
                Imposto::create([
                    'imposto' => $dado,
                    'taxa' => $dados2[$key],
                ]);
            }
        }
    }
}
