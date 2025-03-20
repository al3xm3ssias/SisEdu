<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('disciplina_professor', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('disciplina_id');
        $table->unsignedBigInteger('professor_id'); // Certifique-se que o nome da chave estrangeira esteja correto
        $table->timestamps();

        // Definindo as chaves estrangeiras corretamente
        $table->foreign('disciplina_id')->references('id')->on('disciplinas')->onDelete('cascade');
        $table->foreign('professor_id')->references('id')->on('professores')->onDelete('cascade'); // 'professores' é o nome correto da tabela
    });
}

public function down()
{
    Schema::dropIfExists('disciplina_professor');
}

};
