<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacante_id')->constrained('vacantes')->onDelete('cascade');
            
            // Información personal
            $table->string('cedula')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');
            $table->enum('genero', ['masculino', 'femenino']);
            $table->string('telefono');
            $table->string('celular')->nullable();
            $table->string('email');
            $table->text('direccion');
            $table->string('ciudad');
            $table->string('departamento');
            
            // Información académica y laboral
            $table->enum('nivel_educativo', ['primaria', 'bachillerato', 'tecnico', 'tecnologo', 'profesional', 'especializacion', 'maestria', 'doctorado']);
            $table->string('titulo_obtenido')->nullable();
            $table->string('institucion')->nullable();
            $table->text('experiencia_laboral')->nullable();
            $table->decimal('pretension_salarial', 12, 2)->nullable();
            
            // Archivos y documentos
            $table->string('hoja_vida_path')->nullable();
            $table->json('documentos_adjuntos')->nullable();
            
            // Proceso de selección
            $table->enum('estado', [
                'aplicado',
                'preseleccionado', 
                'entrevista_inicial',
                'pruebas_psicotecnicas',
                'entrevista_tecnica',
                'verificacion_referencias',
                'aprobado',
                'rechazado',
                'contratado'
            ])->default('aplicado');
            
            $table->text('observaciones')->nullable();
            $table->integer('puntaje_total')->nullable();
            $table->date('fecha_aplicacion');
            
            // Campos de auditoría
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};