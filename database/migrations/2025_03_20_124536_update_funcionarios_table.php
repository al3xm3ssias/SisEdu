<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFuncionariosTable extends Migration
{
    public function up()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            // Adicionando a coluna 'turno_id' para associar o turno
            $table->unsignedBigInteger('turno_id')->nullable()->default(0); // Definindo valor padrão como 0 para turno
            $table->foreign('turno_id')->references('id')->on('turnos')->onDelete('set null'); 
        });
    }

    public function down()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropForeign(['turno_id']);
            $table->dropColumn('turno_id');
        });
    }
}

