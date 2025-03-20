<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnosTable extends Migration
{
    public function up()
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao'); // Descrição do turno (manhã, tarde, integral)
            $table->timestamps();
        });

      /*  // Inserindo os turnos padrão na tabela
        DB::table('turnos')->insert([
            ['descricao' => 'Manhã'],
            ['descricao' => 'Tarde'],
            ['descricao' => 'Integral'],
        ]); */
    }

    public function down()
    {
        Schema::dropIfExists('turnos');
    }
}

