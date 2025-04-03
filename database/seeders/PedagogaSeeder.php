<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PedagogaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Pedagoga Maria',
            'email' => 'pedagoga@sisedu.com',
            'password' => Hash::make('123456'),
            'role' => 'pedagoga',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}