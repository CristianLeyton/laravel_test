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
        Schema::table('arrestos', function (Blueprint $table) {
            $table->foreignId('autoridad_id')->nullable()->constrained('autoridades')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arrestos', function (Blueprint $table) {
            $table->dropForeign(['autoridad_id']);
            $table->dropColumn('autoridad_id');
        });
    }
};
