<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class); // Add this line
        $this->call(ShopSeeder::class); // Add this line
        $this->call(UnidadeSeeder::class); // Add this line
        $this->call(TaxaSeeder::class); // Add this line
        $this->call(RegimeSeeder::class); // Add this line
        $this->call(ColorSeeder::class); // Add this line
        $this->call(SizeSeeder::class); // Add this line
        $this->call(MesaSeeder::class); // Add this line

    }
}
