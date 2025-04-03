<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Professor João',
            'email' => 'professor@sisedu.com',
            'password' => Hash::make('123456'),
            'role' => 'professor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

