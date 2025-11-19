<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Nomina extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'periodo',
        'fecha_inicio_periodo',
        'fecha_fin_periodo',
        'fecha_pago',
        'salario_basico',
        'auxilio_transporte',
        'horas_extras',
        'recargos_nocturnos',
        'dominicales_festivos',
        'comisiones',
        'bonificaciones',
        'otros_devengados',
        'total_devengados',
        'salud_empleado',
        'pension_empleado',
        'solidaridad_pensional',
        'retencion_fuente',
        'prestamos',
        'embargos',
        'otros_descuentos',
        'total_deducciones',
        'salud_patronal',
        'pension_patronal',
        'arl',
        'caja_compensacion',
        'icbf',
        'sena',
        'total_aportes_patronales',
        'cesantias',
        'intereses_cesantias',
        'prima_servicios',
        'vacaciones',
        'total_provisiones',
        'neto_pagar',
        'costo_total_empresa',
        'estado',
        'observaciones',
        'detalles_calculo',
        'calculada_by',
        'aprobada_by',
        'fecha_calculo',
        'fecha_aprobacion'
    ];

    protected $casts = [
        'fecha_inicio_periodo' => 'date',
        'fecha_fin_periodo' => 'date',
        'fecha_pago' => 'date',
        'fecha_calculo' => 'datetime',
        'fecha_aprobacion' => 'datetime',
        'detalles_calculo' => 'array',
        'salario_basico' => 'decimal:2',
        'total_devengados' => 'decimal:2',
        'total_deducciones' => 'decimal:2',
        'neto_pagar' => 'decimal:2',
        'costo_total_empresa' => 'decimal:2',
    ];

    // Relaciones
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }

    public function calculadaPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'calculada_by');
    }

    public function aprobadaPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprobada_by');
    }

    // Accessors
    public function getEstadoLabelAttribute(): string
    {
        return match($this->estado) {
            'borrador' => 'Borrador',
            'calculada' => 'Calculada',
            'aprobada' => 'Aprobada',
            'pagada' => 'Pagada',
            'anulada' => 'Anulada',
            default => ucfirst($this->estado)
        };
    }

    public function getEstadoColorAttribute(): string
    {
        return match($this->estado) {
            'borrador' => 'gray',
            'calculada' => 'blue',
            'aprobada' => 'green',
            'pagada' => 'emerald',
            'anulada' => 'red',
            default => 'gray'
        };
    }

    public function getPeriodoFormateadoAttribute(): string
    {
        $fecha = Carbon::createFromFormat('Y-m', $this->periodo);
        return $fecha->translatedFormat('F Y');
    }

    // Scopes
    public function scopePorPeriodo($query, $periodo)
    {
        return $query->where('periodo', $periodo);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopePendientesPago($query)
    {
        return $query->where('estado', 'aprobada');
    }

    // Métodos de negocio
    public function calcularTotales(): void
    {
        // Calcular total devengados
        $this->total_devengados = collect([
            $this->salario_basico,
            $this->auxilio_transporte,
            $this->horas_extras,
            $this->recargos_nocturnos,
            $this->dominicales_festivos,
            $this->comisiones,
            $this->bonificaciones,
            $this->otros_devengados
        ])->sum();

        // Calcular total deducciones
        $this->total_deducciones = collect([
            $this->salud_empleado,
            $this->pension_empleado,
            $this->solidaridad_pensional,
            $this->retencion_fuente,
            $this->prestamos,
            $this->embargos,
            $this->otros_descuentos
        ])->sum();

        // Calcular neto a pagar
        $this->neto_pagar = $this->total_devengados - $this->total_deducciones;

        // Calcular aportes patronales
        $this->total_aportes_patronales = collect([
            $this->salud_patronal,
            $this->pension_patronal,
            $this->arl,
            $this->caja_compensacion,
            $this->icbf,
            $this->sena
        ])->sum();

        // Calcular provisiones
        $this->total_provisiones = collect([
            $this->cesantias,
            $this->intereses_cesantias,
            $this->prima_servicios,
            $this->vacaciones
        ])->sum();

        // Costo total para la empresa
        $this->costo_total_empresa = $this->total_devengados + 
                                   $this->total_aportes_patronales + 
                                   $this->total_provisiones;
    }

    public function puedeCalcularse(): bool
    {
        return $this->estado === 'borrador';
    }

    public function puedeAprobarse(): bool
    {
        return $this->estado === 'calculada';
    }

    public function puedePagarse(): bool
    {
        return $this->estado === 'aprobada';
    }

    public function puedeAnularse(): bool
    {
        return in_array($this->estado, ['borrador', 'calculada', 'aprobada']);
    }

    // Generar número de comprobante
    public function generarNumeroComprobante(): string
    {
        $periodo = str_replace('-', '', $this->periodo);
        $empleado = str_pad($this->empleado_id, 4, '0', STR_PAD_LEFT);
        return "NOM-{$periodo}-{$empleado}";
    }
}