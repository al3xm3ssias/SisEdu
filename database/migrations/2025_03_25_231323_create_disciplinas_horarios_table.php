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
    Schema::create('disciplinas_horarios', function (Blueprint $table) {
        $table->id();
        $table->foreignId('disciplina_id')->constrained('disciplinas')->onDelete('cascade');
        $table->string('dia'); // Dia da semana (por exemplo: 'segunda', 'terça', etc.)
        $table->time('inicio');
        $table->time('fim');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinas_horarios');
    }
};
