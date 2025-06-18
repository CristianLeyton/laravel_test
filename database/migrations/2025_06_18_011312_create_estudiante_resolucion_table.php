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
        Schema::create('estudiante_resolucion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiantes_id')->constrained('estudiantes')->cascadeOnDelete();
            $table->foreignId('resoluciones_id')->constrained('resoluciones')->cascadeOnDelete();
            $table->timestamps();

            // Evitar duplicados
            $table->unique(['estudiantes_id', 'resoluciones_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiante_resolucion');
    }
};
