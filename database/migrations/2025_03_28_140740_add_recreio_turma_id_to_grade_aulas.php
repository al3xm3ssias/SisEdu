<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecreioTurmaIdToGradeAulas extends Migration
{
    public function up(): void
    {
        Schema::table('grade_aulas', function (Blueprint $table) {
            // Adiciona a coluna 'recreio_turma_id' referenciando a tabela 'recreio_turma'
            $table->foreignId('recreio_turma_id')->nullable()->constrained('recreio_turma')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('grade_aulas', function (Blueprint $table) {
            // Remove a coluna 'recreio_turma_id' se for necessário reverter
            $table->dropForeign(['recreio_turma_id']);
            $table->dropColumn('recreio_turma_id');
        });
    }
}
