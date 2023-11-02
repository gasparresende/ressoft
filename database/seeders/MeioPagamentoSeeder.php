<?php

namespace Database\Seeders;

use App\Models\MeioPagamento;
use Illuminate\Database\Seeder;

class MeioPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            'Dinheiro',
            'TPA',
        ];

        foreach ($dados as $dado) {
            $meiopagamentos = MeioPagamento::all()->where('meio', $dado);
            if ($meiopagamentos->count() == 0) {
                MeioPagamento::create([
                    'meio' => $dado,
                ]);
            }

        }
    }
}
