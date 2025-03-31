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
        Schema::table('grade_aulas', function (Blueprint $table) {
            $table->foreignId('ano_letivo_id')->constrained('anos_letivos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('grade_aulas', function (Blueprint $table) {
            $table->dropForeign(['ano_letivo_id']);
            $table->dropColumn('ano_letivo_id');
        });
    }
};
