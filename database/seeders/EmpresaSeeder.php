<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresas = Empresa::all()->where('nome_empresa', 'RESSOFT');
        if ($empresas->count() == 0) {
            Empresa::create([
                'nome_empresa' => 'RESSOFT',
                'nif_empresa' => '0000000000',
                'telemovel_empresa' => '+244 000 000 000',
                'logotipo_empresa' => '/images/logo.png',
                'endereco_empresa' => "Luanda, Angola",
                'website_empresa' => 'https://www.ressoft.com',
                'regimes_id' => 1,
                'taxas_id' => 1,
            ]);
        }
    }
}
