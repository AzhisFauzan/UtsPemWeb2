<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin SIMRS',
            'email' => 'admin@simrs.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Teknisi Budi',
            'email' => 'budi@simrs.test',
            'password' => bcrypt('password'),
            'role' => 'teknisi',
        ]);

        User::create([
            'name' => 'Teknisi Andi',
            'email' => 'andi@simrs.test',
            'password' => bcrypt('password'),
            'role' => 'teknisi',
        ]);
    }
}
