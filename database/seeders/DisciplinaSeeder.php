<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Disciplina;

class DisciplinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Adicionando as disciplinas na tabela
        Disciplina::create(['nome' => 'Matematica']);
        Disciplina::create(['nome' => 'LAC']);
        Disciplina::create(['nome' => 'Ciências']);
        Disciplina::create(['nome' => 'Educação Física']);
        Disciplina::create(['nome' => 'Arte']);
        Disciplina::create(['nome' => 'Português']);
        Disciplina::create(['nome' => 'História']);
        Disciplina::create(['nome' => 'Formação Humana']);
        Disciplina::create(['nome' => 'Campos de Experiência']);
    }
}
