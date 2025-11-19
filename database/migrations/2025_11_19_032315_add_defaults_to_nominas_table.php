<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nominas', function (Blueprint $table) {
            // Cambiar columnas para tener valores por defecto
            $table->decimal('total_devengados', 12, 2)->default(0)->change();
            $table->decimal('total_deducciones', 12, 2)->default(0)->change();
            $table->decimal('total_aportes_patronales', 12, 2)->default(0)->change();
            $table->decimal('total_provisiones', 12, 2)->default(0)->change();
            $table->decimal('neto_pagar', 12, 2)->default(0)->change();
            $table->decimal('costo_total_empresa', 12, 2)->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('nominas', function (Blueprint $table) {
            $table->decimal('total_devengados', 12, 2)->default(null)->change();
            $table->decimal('total_deducciones', 12, 2)->default(null)->change();
            $table->decimal('total_aportes_patronales', 12, 2)->default(null)->change();
            $table->decimal('total_provisiones', 12, 2)->default(null)->change();
            $table->decimal('neto_pagar', 12, 2)->default(null)->change();
            $table->decimal('costo_total_empresa', 12, 2)->default(null)->change();
        });
    }
};