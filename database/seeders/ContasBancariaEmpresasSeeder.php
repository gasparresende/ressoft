<?php

namespace Database\Seeders;

use App\Models\ContasBancariaEmpresas;
use Illuminate\Database\Seeder;

class ContasBancariaEmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresas = ContasBancariaEmpresas::all()->where('numero_conta_empresa', '120000000300001');
        if ($empresas->count() == 0) {
            ContasBancariaEmpresas::create([
                'numero_conta_empresa' => '120000000300001',
                'iban_empresa' => 'AO06000600000120000000300',
                'bancos_id' => 1,
                'empresas_id' => 1,
            ]);
        }
    }
}
