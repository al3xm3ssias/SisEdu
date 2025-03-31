<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecreiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Inserindo os intervalos na tabela 'recreios'
        $cafeManhaId = DB::table('recreios')->insertGetId([
            'nome' => 'Café da Manhã',
            'inicio' => '07:45:00',
            'fim' => '08:00:00',
        ]);

        $almocoId = DB::table('recreios')->insertGetId([
            'nome' => 'Almoço',
            'inicio' => '11:45:00',
            'fim' => '12:45:00',
        ]);


        $lancheId = DB::table('recreios')->insertGetId([
            'nome' => 'Lanche da Tarde',
            'inicio' => '14:45:00',
            'fim' => '15:00:00',
        ]);

        // Associando os intervalos à turma de ID 7 na tabela 'recreio_turma'
        DB::table('recreio_turma')->insert([
            'recreio_id' => $cafeManhaId,
            'turma_id' => 7, // 5º ano
        ]);

        DB::table('recreio_turma')->insert([
            'recreio_id' => $almocoId,
            'turma_id' => 7, // 5º ano
        ]);

        DB::table('recreio_turma')->insert([
            'recreio_id' => $lancheId,
            'turma_id' => 7, // 5º ano
        ]);
    }
}
