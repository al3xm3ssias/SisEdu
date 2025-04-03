<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EscriturarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Escriturário Felipe',
            'email' => 'escriturario@sisedu.com',
            'password' => Hash::make('123456'),
            'role' => 'escriturario',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}