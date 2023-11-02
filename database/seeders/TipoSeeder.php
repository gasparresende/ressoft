<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            'Factura',
            'Factura Recibo',
            'Nota de Crédito',
            'Factura Pró-Forma',
            'Orçamento',
            'Encomenda',
            'Guia de Transporte',
            'Guia de Remessa',
        ];

        $dados2 = [
            'FT',
            'FR',
            'NC',
            'PP',
            'OC',
            'EN',
            'GT',
            'GR',
        ];

        foreach ($dados as $key => $dado) {
            $tipos = Tipo::all()->where('tipo', $dado);
            if ($tipos->count() == 0) {
                Tipo::create([
                    'tipo' => $dado,
                    'sigla' => $dados2[$key],
                ]);
            }

        }
    }
}
