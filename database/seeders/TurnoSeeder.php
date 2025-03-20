<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurnoSeeder extends Seeder
{
    public function run()
    {
        // Definindo os turnos com IDs manuais
        $id = 1; // Começar o ID com 1
        $turnos = ['Manhã', 'Tarde', 'Integral'];

        foreach ($turnos as $descricao) {
            DB::table('turnos')->insert([
                'id' => $id,          // Definindo o ID manualmente
                'descricao' => $descricao,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $id++; // Incrementando o ID para o próximo turno
        }
    }
}

