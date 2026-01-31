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
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->foreignId('lugar_nacimiento_id')->nullable()->constrained('localidades')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('numero_contacto_particular')->nullable();
            $table->string('numero_contacto_emergencia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropForeign(['lugar_nacimiento_id']);
            $table->dropColumn(['lugar_nacimiento_id', 'numero_contacto_particular', 'numero_contacto_emergencia']);
        });
    }
};
