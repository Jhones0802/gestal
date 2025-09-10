<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vacantes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('area');
            $table->text('descripcion');
            $table->text('responsabilidades');
            $table->text('requisitos');
            $table->text('competencias')->nullable();
            $table->decimal('salario_minimo', 12, 2);
            $table->decimal('salario_maximo', 12, 2);
            $table->enum('tipo_contrato', ['indefinido', 'fijo', 'prestacion_servicios', 'temporal']);
            $table->enum('modalidad', ['presencial', 'remoto', 'hibrido']);
            $table->string('ubicacion');
            $table->integer('vacantes_disponibles')->default(1);
            $table->date('fecha_publicacion');
            $table->date('fecha_cierre')->nullable();
            $table->enum('estado', ['borrador', 'publicada', 'cerrada', 'cancelada'])->default('borrador');
            $table->enum('prioridad', ['baja', 'media', 'alta', 'urgente'])->default('media');
            $table->string('contacto_responsable');
            $table->text('proceso_seleccion')->nullable();
            $table->json('documentos_requeridos')->nullable();
            
            // Campos de auditoría
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacantes');
    }
};