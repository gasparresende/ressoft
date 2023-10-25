<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            'Viana',
            'Samba',
            'Benfica'
        ];

        foreach ($dados as $dado) {
            $shops = Shop::all()->where('loja', $dado);
            if ($shops->count() == 0) {
                Shop::create([
                    'loja' => $dado,
                ]);
            }

        }
    }
}
