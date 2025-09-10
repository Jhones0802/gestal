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
        Schema::table('candidatos', function (Blueprint $table) {
            // Cambiar nombre de campo cedula a tipo_documento y numero_documento
            $table->string('tipo_documento')->after('vacante_id')->default('cedula');
            $table->renameColumn('cedula', 'numero_documento');
            
            // Agregar campos faltantes para el portal público
            $table->string('profesion')->nullable()->after('nivel_educativo');
            $table->string('universidad')->nullable()->after('profesion');
            $table->integer('experiencia_anos')->default(0)->after('universidad');
            $table->text('experiencia_area')->nullable()->after('experiencia_anos');
            $table->integer('salario_aspirado')->nullable()->after('experiencia_area');
            $table->boolean('disponibilidad_inmediata')->default(true)->after('salario_aspirado');
            $table->date('fecha_disponibilidad')->nullable()->after('disponibilidad_inmediata');
            
            // Campos de archivos
            $table->string('hoja_vida')->nullable()->after('fecha_disponibilidad'); // Nuevo nombre
            $table->string('carta_presentacion')->nullable()->after('hoja_vida');
            
            // Campo origen de aplicación
            $table->string('origen_aplicacion')->default('manual')->after('observaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidatos', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_documento',
                'profesion',
                'universidad', 
                'experiencia_anos',
                'experiencia_area',
                'salario_aspirado',
                'disponibilidad_inmediata',
                'fecha_disponibilidad',
                'hoja_vida',
                'carta_presentacion',
                'origen_aplicacion'
            ]);
            
            $table->renameColumn('numero_documento', 'cedula');
        });
    }
};