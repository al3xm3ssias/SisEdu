<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Funcionario;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class FuncionarioSeeder extends Seeder
{
    public function run()
    {
        // Instanciando o Faker
        $faker = Faker::create();

        // Gerando 10 funcionários com dados aleatórios
        foreach (range(1, 50) as $index) {
            Funcionario::create([
                'nome' => $faker->name, // Nome aleatório
                'matricula' => $faker->numberBetween(100000, 999999), // Matrícula aleatória e única
                'cargo' => $this->getRandomCargo(), // Cargo aleatório
                'tipo_funcionario' => $faker->boolean, // Tipo de funcionário aleatório (0 ou 1)
                'id_unico' => (string) Str::uuid(), // Gerando o id único
            ]);
        }
    }

    // Função para obter um cargo aleatório
    private function getRandomCargo()
    {
        $cargos = [
            'assistente_educacao' => 'Assistente de Educação',
            'auxiliar_cozinha' => 'Auxiliar de Cozinha',
            'diretor' => 'Diretor',
            'escriturario' => 'Escriturário',
            'estagiario' => 'Estagiário',
            'merendeira' => 'Merendeira',
            'pedagoga' => 'Pedagoga',
            'professor_20h' => 'Professor 20h',
            'professor_40h' => 'Professor 40h',
            'servente_escolar' => 'Servente Escolar'
        ];

        // Retorna um cargo aleatório
        return array_rand($cargos);
    }
}
