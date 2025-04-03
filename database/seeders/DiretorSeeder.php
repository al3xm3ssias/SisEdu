<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DiretorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Diretor Carlos',
            'email' => 'diretor@sisedu.com',
            'password' => Hash::make('123456'),
            'role' => 'diretor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}