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
        Schema::create('domicilios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiantes_id');
            $table->foreign('estudiantes_id')->references('id')->on('estudiantes')->cascadeOnDelete();
            $table->foreignId('tipos_de_domicilios_id')->constrained('tipos_de_domicilios')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('descripcion_domicilio')->nullable();
            $table->string('direccion_estudiante');
            $table->foreignId('localidades_id')->constrained('localidades')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domicilios');
    }
};
