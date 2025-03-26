<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recreios', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Nome do recreio, se houver variações
            $table->time('inicio'); // Hora de início
            $table->time('fim'); // Hora de término
            $table->timestamps();
        });

        Schema::create('recreio_turma', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recreio_id')->constrained('recreios')->onDelete('cascade');
            $table->foreignId('turma_id')->constrained('turmas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recreio_turma');
        Schema::dropIfExists('recreios');
    }
};

