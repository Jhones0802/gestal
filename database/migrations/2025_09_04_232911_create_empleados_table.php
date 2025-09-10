<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('cedula')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');
            $table->enum('genero', ['masculino', 'femenino']);
            $table->enum('estado_civil', ['soltero', 'casado', 'union_libre', 'divorciado', 'viudo']);
            $table->string('telefono');
            $table->string('celular')->nullable();
            $table->string('email')->unique();
            $table->text('direccion');
            $table->string('ciudad');
            $table->string('departamento');
            
            // Información laboral
            $table->string('cargo');
            $table->string('area');
            $table->decimal('salario', 12, 2);
            $table->enum('tipo_contrato', ['indefinido', 'fijo', 'prestacion_servicios', 'temporal']);
            $table->date('fecha_ingreso');
            $table->date('fecha_fin_contrato')->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'liquidado']);
            $table->string('jefe_inmediato')->nullable();
            
            // Información de seguridad social
            $table->string('eps')->nullable();
            $table->string('arl')->nullable();
            $table->string('fondo_pension')->nullable();
            $table->string('caja_compensacion')->nullable();
            
            // Información académica
            $table->enum('nivel_educativo', ['primaria', 'bachillerato', 'tecnico', 'tecnologo', 'profesional', 'especializacion', 'maestria', 'doctorado']);
            $table->string('titulo_obtenido')->nullable();
            $table->string('institucion')->nullable();
            
            // Información de emergencia
            $table->string('contacto_emergencia_nombre');
            $table->string('contacto_emergencia_telefono');
            $table->string('contacto_emergencia_parentesco');
            
            // Campos de auditoría
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};