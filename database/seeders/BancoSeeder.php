<?php

namespace Database\Seeders;

use App\Models\Banco;
use Illuminate\Database\Seeder;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            'BANCO ANGOLANO DE INVESTIMENTO',
            'BANCO DE FOMENTO ANGOLA',
            'BANCO DE INVESTIMENTO COMERCIAL',
            'BANCO DE POUPANÇA E CRÉDITO',
            'BANCO MILENIUM ATLÂNTICO',
            'BANCO DE NEGÓCIOS INTERNACIONAL',
            'BANCO DE COMÉRCIO E INDÚSTRIA',
        ];

        $dados2 = [
            'BAI',
            'BFA',
            'BIC',
            'BPC',
            'BMA',
            'BNI',
            'BCI',
        ];

        foreach ($dados as $key =>$dado) {
            $bancos = Banco::all()->where('nome_banco', $dado);
            if ($bancos->count() == 0) {
                Banco::create([
                    'nome_banco' => $dado,
                    'sigla_banco' => $dados2[$key],
                ]);
            }

        }
    }
}
