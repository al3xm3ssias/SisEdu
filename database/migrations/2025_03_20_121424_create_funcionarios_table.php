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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('matricula')->unique();
            $table->integer('tipo_funcionario')->default(0);
            $table->unsignedBigInteger('cargo_id'); // Este é o campo de relacionamento
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade'); // Chave estrangeira
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
