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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_estudiante');
            $table->string('apellido_estudiante');
            $table->string('dni_estudiante');
            $table->string('cuil_estudiante');
            $table->date('fecha_nacimiento');
            $table->string('num_legajo');
            $table->string('foto_estudiante')->nullable();
            $table->foreignId('aniodelacarrera_id')->constrained('aniodelacarreras')->cascadeOnDelete();
            $table->foreignId('estado_id')->constrained('estados')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
