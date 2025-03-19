<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('cargos', function (Blueprint $table) {
        $table->id();
        $table->string('nome')->unique();
        $table->timestamps();
    });

    // Inserindo os cargos automaticamente
    DB::table('cargos')->insert([
        ['nome' => 'Assistente de Educação'],
        ['nome' => 'Auxiliar de Cozinha'],
        ['nome' => 'Diretor'],
        ['nome' => 'Escriturário'],
        ['nome' => 'Estagiário'],
        ['nome' => 'Merendeira'],
        ['nome' => 'Pedagoga'],
        ['nome' => 'Professor 20h'],
        ['nome' => 'Professor 40h'],
        ['nome' => 'Servente Escolar'],
    ]);
}

public function down()
{
    Schema::dropIfExists('cargos');
}

};
