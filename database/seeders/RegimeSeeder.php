<?php

namespace Database\Seeders;

use App\Models\Regime;
use Illuminate\Database\Seeder;

class RegimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            '0' => 'Regime Simplificado',
            '1' => 'IVA - Regime de Exclusão',
            '2' => 'Regime Geral',
            'M01' => 'Artigo 16.º n.º 6 do CIVA',
            'M02' => 'Isento Artigo 6.º do Decreto-Lei n.º 198/90, de 19 de junhonos termos da alínea c) do nº 1 do artigo 12º do IVA',
            'M03' => 'Exigibilidade de caixa',
            'M04' => 'Isento Artigo 13.º do CIVA',
            'M05' => 'Isento Artigo 14.º do CIVA',
            'M06' => 'Isento Artigo 15.º do CIVA',
            'M07' => 'Isento Artigo 9.º do CIVA',
            'M08' => 'IVA - Autoliquidação',
            'M09' => 'IVA - Não confere direito a dedução',
            'M10' => 'IVA - Regime de isenção',
            'M11' => 'Regime particular do tabaco',
            'M12'=>'Regime da margem de lucro - Agências de viagens'
        ];

        foreach ($dados as $key => $dado) {
            $regimes = Regime::all()->where('regime', $dado);
            if ($regimes->count() == 0) {
                Regime::create([
                    'codigo' => $key,
                    'motivo' => $dado,
                    'taxas_id' => 1
                ]);
            }
        }
    }
}
