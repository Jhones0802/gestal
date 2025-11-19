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
        Schema::create('capacitaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['presencial', 'virtual', 'hibrida'])->default('presencial');
            $table->string('instructor')->nullable();
            $table->string('lugar')->nullable();
            $table->string('link_virtual')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->integer('duracion_horas')->nullable();
            $table->integer('cupo_maximo')->nullable();
            $table->enum('estado', ['programada', 'en_curso', 'completada', 'cancelada'])->default('programada');
            $table->text('objetivos')->nullable();
            $table->text('contenido')->nullable();
            $table->text('requisitos')->nullable();
            $table->text('materiales')->nullable();
            $table->decimal('costo', 10, 2)->nullable();
            $table->string('certificado_tipo')->nullable();
            $table->boolean('notificacion_enviada')->default(false);
            $table->timestamp('fecha_notificacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Tabla pivote para empleados inscritos en capacitaciones
        Schema::create('capacitacion_empleado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capacitacion_id')->constrained('capacitaciones')->onDelete('cascade');
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');
            $table->enum('estado_asistencia', ['invitado', 'confirmado', 'asistio', 'no_asistio', 'cancelado'])->default('invitado');
            $table->boolean('certificado_emitido')->default(false);
            $table->decimal('calificacion', 3, 2)->nullable();
            $table->text('comentarios')->nullable();
            $table->timestamp('fecha_confirmacion')->nullable();
            $table->timestamp('fecha_notificacion')->nullable();
            $table->timestamps();

            $table->unique(['capacitacion_id', 'empleado_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacitacion_empleado');
        Schema::dropIfExists('capacitaciones');
    }
};
