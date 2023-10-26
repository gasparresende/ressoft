<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            'M',
            'L',
            'XL',
            'S',
            '40',
            '41',
            '42',
            '43'
        ];

        foreach ($dados as $key => $dado) {
            $size = Size::create([
                'size' => $dado,
            ]);
        }
    }
}
