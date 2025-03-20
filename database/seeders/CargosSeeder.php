<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargosSeeder extends Seeder
{
    // Cargos definidos
    public static $cargos = [
        'assistente_educacao' => 'Assistente de Educação',
        'auxiliar_cozinha'    => 'Auxiliar de Cozinha',
        'diretor'             => 'Diretor',
        'escriturario'        => 'Escriturário',
        'estagiario'          => 'Estagiário',
        'merendeira'          => 'Merendeira',
        'pedagoga'            => 'Pedagoga',
        'professor_20h'       => 'Professor 20h',
        'professor_40h'       => 'Professor 40h',
        'servente_escolar'    => 'Servente Escolar'
    ];

    public function run()
    {
        $id = 1; // Inicia o ID com 0
        foreach (self::$cargos as $key => $name) {
            DB::table('cargos')->insert([
                'id' => $id,          // Definindo o ID manualmente
                'nome' => $name,
                // 'slug' => $key, // Descomente se precisar do slug
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $id++; // Incrementa o ID para o próximo cargo
        }
    }
}

