<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Funcionario;

class FuncionarioSeeder extends Seeder
{
    public function run()
    {
        // Inserir os dados dos funcionários com turnos corretos

        // Claudio: Escriturário e Integral
        Funcionario::create([
            'matricula' => '30627',
            'nome' => 'CLAUDIO ALEX MESSIAS DA ROSA',
            'cargo_id' => 4, // Escriturário
            'tipo_funcionario' => 0, // Concursado
            'turno_id' => 3, // Turno Integral (ID do turno Integral)
        ]);

        // Elci: Professor 20h Manhã
        Funcionario::create([
            'matricula' => '12967',
            'nome' => 'ELCI CRISTINA KRUGER',
            'cargo_id' => 8, // Professor 20h
            'tipo_funcionario' => 0, // Concursado
            'turno_id' => 1, // Turno Integral (ID do turno Integral)
        ]);

        // Vanessa: Professor 20h Tarde
        Funcionario::create([
            'matricula' => '16919',
            'nome' => 'VANESSA DE FATIMA MACHADO DE PAULA',
            'cargo_id' => 8, // Professor 20h
            'tipo_funcionario' => 0, // Concursado
            'turno_id' => 2, // Turno Integral (ID do turno Integral)
        ]);

        // Valdemir: Assistente de Educação e Integral
        Funcionario::create([
            'matricula' => '31338',
            'nome' => 'VALDEMIR DAVI DE OLIVEIRA',
            'cargo_id' => 1, // Assistente de Educação
            'tipo_funcionario' => 0, // Concursado
            'turno_id' => 3, // Turno Integral (ID do turno Integral)
        ]);

        // Ana Paula: Professor 40h e Integral
        Funcionario::create([
            'matricula' => '20793',
            'nome' => 'ANA PAULA HAILE',
            'cargo_id' => 9, // Professor 40h
            'tipo_funcionario' => 0, // Concursado
            'turno_id' => 3, // Turno Integral (ID do turno Integral)
        ]);

        // Zeneide: Professor 20h e Integral
        Funcionario::create([
            'matricula' => '25482',
            'nome' => 'ZENEIDE PADILHA DE OLIVEIRA',
            'cargo_id' => 8, // Professor 20h
            'tipo_funcionario' => 0, // Concursado
            'turno_id' => 1, // Turno Integral (ID do turno Integral)
        ]);

        // Priscila: Professor 40h e Integral
        Funcionario::create([
            'matricula' => '30440',
            'nome' => 'PRISCILA FERREIRA DE ANDRADE',
            'cargo_id' => 9, // Professor 40h
            'tipo_funcionario' => 0, // Concursado
            'turno_id' => 3, // Turno Integral (ID do turno Integral)
        ]);
    }
}


