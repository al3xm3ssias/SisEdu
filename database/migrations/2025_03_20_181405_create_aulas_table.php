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
        Schema::create('aulas', function (Blueprint $table) {
            $table->id(); // ID da aula
            $table->foreignId('turma_id')->constrained()->onDelete('cascade'); // Relacionamento com a tabela turmas
            $table->foreignId('professor_id')->constrained('professores')->onDelete('cascade'); // Relacionamento com a tabela professores
            $table->foreignId('disciplina_id')->constrained()->onDelete('cascade'); // Relacionamento com a tabela disciplinas
            $table->string('horario'); // Horário da aula
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aulas');
    }
};
