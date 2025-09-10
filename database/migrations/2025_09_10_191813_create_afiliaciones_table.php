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
        Schema::create('afiliaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');
            $table->enum('entidad_tipo', ['eps', 'arl', 'caja_compensacion', 'fondo_pensiones']);
            $table->string('entidad_nombre'); // Ejemplo: "Sura EPS", "Positiva ARL"
            $table->enum('estado', ['pendiente', 'en_proceso', 'enviada', 'aprobada', 'rechazada', 'completada'])->default('pendiente');
            
            // Información de la solicitud
            $table->string('numero_radicado')->nullable();
            $table->date('fecha_solicitud');
            $table->date('fecha_envio')->nullable();
            $table->date('fecha_respuesta')->nullable();
            $table->date('fecha_afiliacion_efectiva')->nullable();
            
            // Documentos y archivos
            $table->json('documentos_requeridos')->nullable(); // Lista de documentos necesarios
            $table->json('documentos_adjuntos')->nullable();   // Archivos subidos
            $table->string('certificado_afiliacion')->nullable(); // PDF generado
            
            // Información adicional
            $table->string('numero_afiliado')->nullable(); // Número asignado por la entidad
            $table->text('observaciones')->nullable();
            $table->text('motivo_rechazo')->nullable();
            
            // Control de notificaciones
            $table->boolean('notificacion_empleado_enviada')->default(false);
            $table->timestamp('fecha_ultima_notificacion')->nullable();
            
            // Simulación de respuesta automática
            $table->integer('dias_respuesta_estimados')->default(5);
            $table->timestamp('fecha_respuesta_estimada')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            
            // Índices
            $table->index(['empleado_id', 'entidad_tipo']);
            $table->index(['estado']);
            $table->index(['fecha_respuesta_estimada']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('afiliaciones');
    }
};