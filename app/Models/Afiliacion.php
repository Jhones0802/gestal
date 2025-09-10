<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Afiliacion extends Model
{
    use HasFactory;

    protected $table = 'afiliaciones';

    protected $fillable = [
        'empleado_id',
        'entidad_tipo',
        'entidad_nombre',
        'estado',
        'numero_radicado',
        'fecha_solicitud',
        'fecha_envio',
        'fecha_respuesta',
        'fecha_afiliacion_efectiva',
        'documentos_requeridos',
        'documentos_adjuntos',
        'certificado_afiliacion',
        'numero_afiliado',
        'observaciones',
        'motivo_rechazo',
        'notificacion_empleado_enviada',
        'fecha_ultima_notificacion',
        'dias_respuesta_estimados',
        'fecha_respuesta_estimada',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_envio' => 'date',
        'fecha_respuesta' => 'date',
        'fecha_afiliacion_efectiva' => 'date',
        'documentos_requeridos' => 'array',
        'documentos_adjuntos' => 'array',
        'notificacion_empleado_enviada' => 'boolean',
        'fecha_ultima_notificacion' => 'datetime',
        'fecha_respuesta_estimada' => 'datetime',
        'dias_respuesta_estimados' => 'integer',
    ];

    // Relaciones
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Mutators y Accessors
    public function getEntidadTipoLabelAttribute(): string
    {
        return match($this->entidad_tipo) {
            'eps' => 'EPS',
            'arl' => 'ARL',
            'caja_compensacion' => 'Caja de Compensación',
            'fondo_pensiones' => 'Fondo de Pensiones',
            default => $this->entidad_tipo
        };
    }

    public function getEstadoLabelAttribute(): string
    {
        return match($this->estado) {
            'pendiente' => 'Pendiente',
            'en_proceso' => 'En Proceso',
            'enviada' => 'Enviada',
            'aprobada' => 'Aprobada',
            'rechazada' => 'Rechazada',
            'completada' => 'Completada',
            default => ucfirst($this->estado)
        };
    }

    public function getEstadoColorAttribute(): string
    {
        return match($this->estado) {
            'pendiente' => 'gray',
            'en_proceso' => 'yellow',
            'enviada' => 'blue',
            'aprobada' => 'green',
            'rechazada' => 'red',
            'completada' => 'emerald',
            default => 'gray'
        };
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->whereIn('estado', ['pendiente', 'en_proceso', 'enviada']);
    }

    public function scopePorVencer($query)
    {
        return $query->where('fecha_respuesta_estimada', '<=', now()->addDays(2))
                    ->whereIn('estado', ['enviada', 'en_proceso']);
    }

    public function scopePorEntidad($query, $tipo)
    {
        return $query->where('entidad_tipo', $tipo);
    }

    // Métodos de negocio
    public function generarNumeroRadicado(): string
    {
        $entidad = strtoupper(substr($this->entidad_tipo, 0, 3));
        $fecha = now()->format('Ymd');
        $random = rand(1000, 9999);
        return "{$entidad}-{$fecha}-{$random}";
    }

    public function generarNumeroAfiliado(): string
    {
        $entidad = strtoupper(substr($this->entidad_tipo, 0, 2));
        $empleado = str_pad($this->empleado_id, 4, '0', STR_PAD_LEFT);
        $random = rand(100000, 999999);
        return "{$entidad}{$empleado}{$random}";
    }

    public function calcularFechaRespuestaEstimada(): void
    {
        if ($this->fecha_envio && $this->dias_respuesta_estimados) {
            $this->fecha_respuesta_estimada = $this->fecha_envio->copy()->addDays((int) $this->dias_respuesta_estimados);
        }
    }

    public function estaVencida(): bool
    {
        return $this->fecha_respuesta_estimada && 
               $this->fecha_respuesta_estimada < now() && 
               in_array($this->estado, ['enviada', 'en_proceso']);
    }

    public function puedeEnviarse(): bool
    {
        return $this->estado === 'pendiente' && !empty($this->documentos_adjuntos);
    }

    public function puedeCompletarse(): bool
    {
        return $this->estado === 'aprobada';
    }

    // Documentos requeridos por defecto según tipo de entidad
    public static function getDocumentosRequeridos($tipoEntidad): array
    {
        return match($tipoEntidad) {
            'eps' => [
                'Cédula de ciudadanía',
                'Carta laboral',
                'Formulario de afiliación EPS',
                'Certificado de ingresos'
            ],
            'arl' => [
                'Cédula de ciudadanía',
                'Carta laboral',
                'Formulario de afiliación ARL',
                'Descripción del cargo'
            ],
            'caja_compensacion' => [
                'Cédula de ciudadanía',
                'Carta laboral',
                'Formulario de afiliación Caja',
                'Registro civil beneficiarios'
            ],
            'fondo_pensiones' => [
                'Cédula de ciudadanía',
                'Carta laboral',
                'Formulario de afiliación Fondo',
                'Historia laboral'
            ],
            default => ['Cédula de ciudadanía', 'Carta laboral']
        };
    }
}