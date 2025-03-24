<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurmaDisciplinaSeeder extends Seeder
{
    public function run()
    {
        // Zera a tabela e reinicia os IDs
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('turma_disciplinas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Disciplinas específicas para INF IV e INF V
        $disciplinasInfantil = [9, 4, 5, 2]; // Campos de Experiência, Ed. Física, Arte, LAC

        // Disciplinas para 1º ao 5º ano (todas exceto Campos de Experiência)
        $disciplinasGerais = [1, 2, 3, 4, 5, 6, 7, 8]; // Sem a 9 (Campos de Experiência)

        // Turmas INFANTIL IV e INFANTIL V
        foreach ([1, 2] as $turmaId) {
            foreach ($disciplinasInfantil as $disciplinaId) {
                DB::table('turma_disciplinas')->insert([
                    'turma_id' => $turmaId,
                    'disciplina_id' => $disciplinaId,
                ]);
            }
        }

        // Turmas do 1º ao 5º ano (3 a 7)
        foreach ([3, 4, 5, 6, 7, 8] as $turmaId) {
            foreach ($disciplinasGerais as $disciplinaId) {
                DB::table('turma_disciplinas')->insert([
                    'turma_id' => $turmaId,
                    'disciplina_id' => $disciplinaId,
                ]);
            }
        }
    }
}

