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
        Schema::create('turma_professor_disciplinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('professores');
            $table->foreignId('turma_id')->constrained();
          //  $table->text('disciplinas_id'); // Se for uma string com os IDs separados por vírgula
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turma_professor_disciplinas');
    }
};
