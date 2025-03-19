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
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropUnique(['matricula']); // Remove a restrição de unicidade
        });
    }
    
    public function down()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->unique('matricula'); // Restaura a restrição de unicidade
        });
    }
};