<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => Hash::make('admin'),
                'fechaLimite' => '2050-01-01',
                'tipo' => 'ADMINISTRADOR',
            ],
            [
                'name' => 'Fabricio Galvez Rodriguez',
                'email' => 'fabricio@gmail.com',
                'fechaLimite' => '2050-01-01',
                'password' => Hash::make('admin'),
                'tipo' => 'ADMINISTRADOR',
            ],
        ]);
    }
}
