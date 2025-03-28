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
    Schema::create('grade_aulas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('turma_id')->constrained()->onDelete('cascade');
        $table->foreignId('disciplina_id')->nullable()->constrained()->onDelete('cascade');
       // $table->foreignId('recreio_turma_id')->nullable()->constrained()->onDelete('cascade'); // Campo para referenciar o recreio
        $table->string('dia_semana'); // Segunda, Terça, etc.
        $table->time('hora_inicio'); // Horário de início da aula
        $table->time('hora_fim'); // Horário de fim da aula
        $table->integer('duracao'); // Duração da aula em minutos
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
