<?php

namespace Database\Factories;

use App\Models\Funcionario;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuncionarioFactory extends Factory
{
    protected $model = Funcionario::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name(),
            'matricula' => $this->faker->numerify('######'), // Ex: 123456
            'cargo' => array_rand([
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
            ]),
            'tipo_funcionario' => rand(0, 1), // 0 = Concursado, 1 = Terceirizado
        ];
    }

   
}

