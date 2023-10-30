<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Statu;
use Illuminate\Database\Seeder;

class StatuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            'Aberto',
            'Fechado',
            'Ocupado',
            'Reservado',
            'Solicitado',
            'Em preparação',
            'Disponível',
        ];

        foreach ($dados as $key => $dado) {
            $statu = Statu::all()->where('statu', $dado);
            if ($statu->isEmpty()){
                $statu = Statu::create([
                    'statu' => $dado,
                ]);
            }

        }
    }
}
