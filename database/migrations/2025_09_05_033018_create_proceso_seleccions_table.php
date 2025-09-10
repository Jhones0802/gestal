<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proceso_seleccions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidato_id')->constrained('candidatos')->onDelete('cascade');
            $table->enum('tipo_evaluacion', [
                'entrevista_inicial',
                'prueba_psicotecnica',
                'entrevista_tecnica',
                'verificacion_referencias',
                'examen_medico'
            ]);
            
            $table->date('fecha_programada');
            $table->time('hora_programada')->nullable();
            $table->date('fecha_realizada')->nullable();
            $table->enum('estado', ['programada', 'realizada', 'cancelada', 'reprogramada'])->default('programada');
            
            // Resultados de la evaluación
            $table->integer('puntaje')->nullable();
            $table->integer('puntaje_maximo')->default(100);
            $table->enum('resultado', ['aprobado', 'rechazado', 'pendiente'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->text('fortalezas')->nullable();
            $table->text('debilidades')->nullable();
            $table->text('recomendaciones')->nullable();
            
            // Información específica según el tipo
            $table->string('entrevistador')->nullable(); // Para entrevistas
            $table->string('lugar_evaluacion')->nullable();
            $table->json('competencias_evaluadas')->nullable(); // Para guardar puntajes específicos
            $table->string('archivo_resultado')->nullable(); // Para adjuntar reportes
            
            // Campos de auditoría
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proceso_seleccions');
    }
};