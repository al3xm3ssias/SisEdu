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
    Schema::create('turma_funcionario', function (Blueprint $table) {
        $table->id();
        $table->foreignId('turma_id')->constrained()->onDelete('cascade');
        $table->foreignId('funcionario_id')->constrained('funcionarios')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turma_funcionario');
    }
};
