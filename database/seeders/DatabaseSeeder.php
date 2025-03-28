<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

     public function run()
     {
         // Chama o seeder para os Turnos
         $this->call(TurnoSeeder::class);
 
         // Chama o seeder para as Disciplinas
         $this->call(DisciplinaSeeder::class);


         $this->call(CargosSeeder::class);
 
         // Chama o seeder para os Funcionários
         $this->call(FuncionarioSeeder::class);
 
         // Adicione outros seeders conforme necessário

         $this->call(TurmasSeeder::class);

         $this->call(TurmaDisciplinaSeeder::class);
         
         $this->call(RecreiosSeeder::class);
     }


}
