<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('professor_turma', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('professores')->onDelete('cascade'); // Corrigido para 'professores'
            $table->foreignId('turma_id')->constrained()->onDelete('cascade'); // A tabela de turmas provavelmente já é plural
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('professor_turma');
    }
};


