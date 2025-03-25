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

        // Inserindo as disciplinas com ID fixo
        DB::table('disciplinas')->insert([
            ['id' => 1, 'nome' => 'Matemática'],
            ['id' => 2, 'nome' => 'LAC'],
            ['id' => 3, 'nome' => 'Ciências'],
            ['id' => 4, 'nome' => 'Educação Física'],
            ['id' => 5, 'nome' => 'Arte'],
            ['id' => 6, 'nome' => 'Português'],
            ['id' => 7, 'nome' => 'História'],
            ['id' => 8, 'nome' => 'Formação Humana'],
            ['id' => 9, 'nome' => 'Campos de Experiência'],
            ['id' => 10, 'nome' => 'Geografia'],
        ]);
    }
}

