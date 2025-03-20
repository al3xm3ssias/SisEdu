<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turma;

class TurmasSeeder extends Seeder
{
    public function run()
    {
        // Inserir as turmas com IDs fixos
        Turma::create([
            'id' => 1,
            'nome' => 'INFANTIL IV',
        ]);

        Turma::create([
            'id' => 2,
            'nome' => 'INFANTIL V',
        ]);

        Turma::create([
            'id' => 3,
            'nome' => '1º ANO A',
        ]);

        Turma::create([
            'id' => 4,
            'nome' => '2º ANO A',
        ]);

        Turma::create([
            'id' => 5,
            'nome' => '3º ANO A',
        ]);

        Turma::create([
            'id' => 6,
            'nome' => '4º ANO A',
        ]);

        Turma::create([
            'id' => 7,
            'nome' => '5º ANO A',
        ]);

        Turma::create([
            'id' => 8,
            'nome' => '2º ANO B',
        ]);
    }
}
