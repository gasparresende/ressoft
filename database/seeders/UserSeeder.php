<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::all();
        if ($user->isEmpty())
            User::create([
                'username' => 'admin',
                'name' => 'Administrator',
                'email' => 'gaspar.resende@hotmail.com',
                'password' => Hash::make('admin')
            ]);
    }
}
