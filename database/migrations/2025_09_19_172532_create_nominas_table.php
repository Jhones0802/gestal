<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nominas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained()->onDelete('cascade');
            $table->string('periodo'); // "2025-09" para septiembre 2025
            $table->date('fecha_inicio_periodo');
            $table->date('fecha_fin_periodo');
            $table->date('fecha_pago');
            
            // Devengados
            $table->decimal('salario_basico', 12, 2);
            $table->decimal('auxilio_transporte', 10, 2)->default(0);
            $table->decimal('horas_extras', 10, 2)->default(0);
            $table->decimal('recargos_nocturnos', 10, 2)->default(0);
            $table->decimal('dominicales_festivos', 10, 2)->default(0);
            $table->decimal('comisiones', 10, 2)->default(0);
            $table->decimal('bonificaciones', 10, 2)->default(0);
            $table->decimal('otros_devengados', 10, 2)->default(0);
            $table->decimal('total_devengados', 12, 2);
            
            // Deducciones
            $table->decimal('salud_empleado', 10, 2)->default(0);
            $table->decimal('pension_empleado', 10, 2)->default(0);
            $table->decimal('solidaridad_pensional', 10, 2)->default(0);
            $table->decimal('retencion_fuente', 10, 2)->default(0);
            $table->decimal('prestamos', 10, 2)->default(0);
            $table->decimal('embargos', 10, 2)->default(0);
            $table->decimal('otros_descuentos', 10, 2)->default(0);
            $table->decimal('total_deducciones', 12, 2);
            
            // Aportes patronales
            $table->decimal('salud_patronal', 10, 2)->default(0);
            $table->decimal('pension_patronal', 10, 2)->default(0);
            $table->decimal('arl', 10, 2)->default(0);
            $table->decimal('caja_compensacion', 10, 2)->default(0);
            $table->decimal('icbf', 10, 2)->default(0);
            $table->decimal('sena', 10, 2)->default(0);
            $table->decimal('total_aportes_patronales', 12, 2);
            
            // Provisiones
            $table->decimal('cesantias', 10, 2)->default(0);
            $table->decimal('intereses_cesantias', 10, 2)->default(0);
            $table->decimal('prima_servicios', 10, 2)->default(0);
            $table->decimal('vacaciones', 10, 2)->default(0);
            $table->decimal('total_provisiones', 12, 2);
            
            // Totales finales
            $table->decimal('neto_pagar', 12, 2);
            $table->decimal('costo_total_empresa', 12, 2);
            
            // Control
            $table->enum('estado', ['borrador', 'calculada', 'aprobada', 'pagada', 'anulada'])->default('borrador');
            $table->text('observaciones')->nullable();
            $table->json('detalles_calculo')->nullable(); // Guardar detalles del cálculo
            
            $table->foreignId('calculada_by')->nullable()->constrained('users');
            $table->foreignId('aprobada_by')->nullable()->constrained('users');
            $table->timestamp('fecha_calculo')->nullable();
            $table->timestamp('fecha_aprobacion')->nullable();
            
            $table->timestamps();
            
            // Índices
            $table->unique(['empleado_id', 'periodo']);
            $table->index('periodo');
            $table->index('estado');
            $table->index('fecha_pago');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nominas');
    }
};