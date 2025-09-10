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
        Schema::table('vacantes', function (Blueprint $table) {
            // Solo agregar las columnas que faltan
            $table->integer('visualizaciones')->default(0)->after('updated_at');
            $table->integer('aplicaciones')->default(0)->after('visualizaciones');
            // fecha_publicacion ya existe, no la agregamos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacantes', function (Blueprint $table) {
            $table->dropColumn(['visualizaciones', 'aplicaciones']);
            // No eliminamos fecha_publicacion porque ya existía
        });
    }
};