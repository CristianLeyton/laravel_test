<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('arrestos', function (Blueprint $table) {
            $table->id();
            $table->string('fecha_de_arresto');
            $table->integer('dias_de_arresto');
            $table->timestamps();
        });

        Schema::create('arrestos_faltas', function (Blueprint $table) {
            $table->foreignId('faltas_id')->constrained('faltas')->cascadeOnDelete();
            $table->foreignId('arrestos_id')->constrained('arrestos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arrestos');
    }
};
