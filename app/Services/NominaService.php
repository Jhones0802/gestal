<?php

namespace App\Services;

use App\Models\Nomina;
use App\Models\Empleado;
use Carbon\Carbon;

class NominaService
{
    // Constantes para cálculos 2025
    const SALARIO_MINIMO = 1300000;
    const AUXILIO_TRANSPORTE = 162000;
    const UVT = 47065; // Unidad de Valor Tributario 2025
    
    // Porcentajes de ley
    const SALUD_EMPLEADO = 4.0;
    const PENSION_EMPLEADO = 4.0;
    const SOLIDARIDAD_PENSIONAL = 1.0; // Para salarios > 4 SMMLV
    
    const SALUD_PATRONAL = 8.5;
    const PENSION_PATRONAL = 12.0;
    const ARL_BASE = 0.522; // Promedio riesgo I-II
    const CAJA_COMPENSACION = 4.0;
    const ICBF = 3.0;
    const SENA = 2.0;
    
    // Provisiones
    const CESANTIAS = 8.33;
    const INTERESES_CESANTIAS = 1.0;
    const PRIMA_SERVICIOS = 8.33;
    const VACACIONES = 4.17;

    public function calcularNomina(Nomina $nomina): Nomina
    {
        $empleado = $nomina->empleado;
        
        // 1. Calcular devengados base
        $this->calcularDevengados($nomina, $empleado);
        
        // 2. Calcular deducciones
        $this->calcularDeducciones($nomina, $empleado);
        
        // 3. Calcular aportes patronales
        $this->calcularAportesPatronales($nomina, $empleado);
        
        // 4. Calcular provisiones
        $this->calcularProvisiones($nomina, $empleado);
        
        // 5. Calcular totales
        $nomina->calcularTotales();
        
        // 6. Marcar como calculada
        $nomina->estado = 'calculada';
        $nomina->fecha_calculo = now();
        $nomina->calculada_by = auth()->id();
        
        // 7. Guardar detalles del cálculo
        $nomina->detalles_calculo = $this->generarDetallesCalculo($nomina, $empleado);
        
        return $nomina;
    }

    private function calcularDevengados(Nomina $nomina, Empleado $empleado): void
    {
        // Salario básico (ya viene del empleado)
        $nomina->salario_basico = $empleado->salario;
        
        // Auxilio de transporte (si gana <= 2 SMMLV)
        if ($empleado->salario <= (self::SALARIO_MINIMO * 2)) {
            $nomina->auxilio_transporte = self::AUXILIO_TRANSPORTE;
        }
        
        // Horas extras, recargos, etc. (se pueden ingresar manualmente)
        // Por ahora los dejamos en 0, se pueden modificar desde la interfaz
    }

    private function calcularDeducciones(Nomina $nomina, Empleado $empleado): void
    {
        $salarioBase = $nomina->salario_basico;
        
        // Salud empleado (4%)
        $nomina->salud_empleado = $salarioBase * (self::SALUD_EMPLEADO / 100);
        
        // Pensión empleado (4%)
        $nomina->pension_empleado = $salarioBase * (self::PENSION_EMPLEADO / 100);
        
        // Solidaridad pensional (1% si gana > 4 SMMLV)
        if ($salarioBase > (self::SALARIO_MINIMO * 4)) {
            $nomina->solidaridad_pensional = $salarioBase * (self::SOLIDARIDAD_PENSIONAL / 100);
        }
        
        // Retención en la fuente
        $nomina->retencion_fuente = $this->calcularRetencionFuente($nomina);
    }

    private function calcularAportesPatronales(Nomina $nomina, Empleado $empleado): void
    {
        $salarioBase = $nomina->salario_basico;
        
        // Salud patronal (8.5%)
        $nomina->salud_patronal = $salarioBase * (self::SALUD_PATRONAL / 100);
        
        // Pensión patronal (12%)
        $nomina->pension_patronal = $salarioBase * (self::PENSION_PATRONAL / 100);
        
        // ARL (varía según riesgo, usamos promedio)
        $nomina->arl = $salarioBase * (self::ARL_BASE / 100);
        
        // Caja de compensación (4%)
        $nomina->caja_compensacion = $salarioBase * (self::CAJA_COMPENSACION / 100);
        
        // ICBF (3%)
        $nomina->icbf = $salarioBase * (self::ICBF / 100);
        
        // SENA (2%)
        $nomina->sena = $salarioBase * (self::SENA / 100);
    }

    private function calcularProvisiones(Nomina $nomina, Empleado $empleado): void
    {
        $baseProvision = $nomina->salario_basico + $nomina->auxilio_transporte;
        
        // Cesantías (8.33% anual / 12 meses)
        $nomina->cesantias = ($baseProvision * self::CESANTIAS) / 100;
        
        // Intereses cesantías (1% anual sobre cesantías / 12)
        $nomina->intereses_cesantias = ($nomina->cesantias * self::INTERESES_CESANTIAS) / 100;
        
        // Prima de servicios (8.33% anual / 12)
        $nomina->prima_servicios = ($baseProvision * self::PRIMA_SERVICIOS) / 100;
        
        // Vacaciones (4.17% anual / 12) - solo sobre salario básico
        $nomina->vacaciones = ($nomina->salario_basico * self::VACACIONES) / 100;
    }

    private function calcularRetencionFuente(Nomina $nomina): float
    {
        // Cálculo simplificado de retención en la fuente
        $ingresoMensual = $nomina->total_devengados;
        $ingresoAnual = $ingresoMensual * 12;
        
        // Solo aplica si supera cierto umbral
        if ($ingresoAnual <= (self::UVT * 1090)) {
            return 0;
        }
        
        // Cálculo básico (se puede mejorar con tabla completa)
        $baseRetencion = $ingresoMensual - (self::UVT * 90);
        
        if ($baseRetencion <= 0) {
            return 0;
        }
        
        return $baseRetencion * 0.19; // Tarifa básica simplificada
    }

    private function generarDetallesCalculo(Nomina $nomina, Empleado $empleado): array
    {
        return [
            'salario_minimo_aplicado' => self::SALARIO_MINIMO,
            'auxilio_transporte_aplicado' => self::AUXILIO_TRANSPORTE,
            'uvt_aplicada' => self::UVT,
            'porcentajes_aplicados' => [
                'salud_empleado' => self::SALUD_EMPLEADO,
                'pension_empleado' => self::PENSION_EMPLEADO,
                'salud_patronal' => self::SALUD_PATRONAL,
                'pension_patronal' => self::PENSION_PATRONAL,
                'arl' => self::ARL_BASE,
                'caja_compensacion' => self::CAJA_COMPENSACION,
                'icbf' => self::ICBF,
                'sena' => self::SENA,
            ],
            'fecha_calculo' => now()->toISOString(),
            'calculado_por' => auth()->user()->name ?? 'Sistema'
        ];
    }

    public function crearNominasPeriodo(string $periodo): array
    {
        $empleadosActivos = Empleado::activos()->get();
        $nominasCreadas = [];
        
        foreach ($empleadosActivos as $empleado) {
            // Verificar que no exista ya una nómina ACTIVA para este periodo
            $existente = Nomina::where('empleado_id', $empleado->id)
                            ->where('periodo', $periodo)
                            ->where('estado', '!=', 'anulada') // ← Ignorar anuladas
                            ->first();
            
            if ($existente) {
                continue;
            }
            
            $nomina = $this->crearNominaEmpleado($empleado, $periodo);
            $nominasCreadas[] = $nomina;
        }
        
        return $nominasCreadas;
    }
    private function crearNominaEmpleado(Empleado $empleado, string $periodo): Nomina
    {
        $fechas = $this->calcularFechasPeriodo($periodo);
        
        return Nomina::create([
            'empleado_id' => $empleado->id,
            'periodo' => $periodo,
            'fecha_inicio_periodo' => $fechas['inicio'],
            'fecha_fin_periodo' => $fechas['fin'],
            'fecha_pago' => $fechas['pago'],
            'salario_basico' => $empleado->salario,
            'estado' => 'borrador'
        ]);
    }

    private function calcularFechasPeriodo(string $periodo): array
    {
        $fecha = Carbon::createFromFormat('Y-m', $periodo);
        
        return [
            'inicio' => $fecha->copy()->startOfMonth(),
            'fin' => $fecha->copy()->endOfMonth(),
            'pago' => $fecha->copy()->endOfMonth()->addDay() // Siguiente día hábil
        ];
    }
}