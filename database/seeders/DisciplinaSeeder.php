<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Disciplina;

class DisciplinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Zera a tabela e reinicia os IDs
    DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Desativa verificação de chave estrangeira
    Disciplina::truncate(); // Limpa a tabela e reseta os IDs
    DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Reativa verificação

    // Inserindo as disciplinas com ID fixo e a carga horária conforme especificado
    DB::table('disciplinas')->insert([
        ['id' => 1, 'nome' => 'Matemática', 'carga_horaria_max' => 450],
        ['id' => 2, 'nome' => 'LAC', 'carga_horaria_max' => 90],
        ['id' => 3, 'nome' => 'Ciências', 'carga_horaria_max' => 90],
        ['id' => 4, 'nome' => 'Educação Física', 'carga_horaria_max' => 180],
        ['id' => 5, 'nome' => 'Arte', 'carga_horaria_max' => 60],
        ['id' => 6, 'nome' => 'Português', 'carga_horaria_max' => 450],
        ['id' => 7, 'nome' => 'História', 'carga_horaria_max' => 90],
        ['id' => 8, 'nome' => 'Formação Humana', 'carga_horaria_max' => 90],
        ['id' => 9, 'nome' => 'Campos de Experiência', 'carga_horaria_max' => 0],
        ['id' => 10, 'nome' => 'Geografia', 'carga_horaria_max' => 90],
        ['id' => 11, 'nome' => 'Inglês', 'carga_horaria_max' => 90], // Disciplina de Inglês

        ['id' => 99, 'nome' => 'Livre', 'carga_horaria_max' => 9999], // Disciplina livre
    ]);
}
}

