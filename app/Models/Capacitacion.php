<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Capacitacion extends Model
{
    use HasFactory;

    protected $table = 'capacitaciones';

    protected $fillable = [
        'titulo',
        'descripcion',
        'tipo',
        'instructor',
        'lugar',
        'link_virtual',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'duracion_horas',
        'cupo_maximo',
        'estado',
        'objetivos',
        'contenido',
        'requisitos',
        'materiales',
        'costo',
        'certificado_tipo',
        'notificacion_enviada',
        'fecha_notificacion',
        'observaciones',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'costo' => 'decimal:2',
        'notificacion_enviada' => 'boolean',
        'fecha_notificacion' => 'datetime',
    ];

    // Relaciones
    public function empleados()
    {
        return $this->belongsToMany(Empleado::class, 'capacitacion_empleado')
                    ->withPivot([
                        'estado_asistencia',
                        'certificado_emitido',
                        'calificacion',
                        'comentarios',
                        'fecha_confirmacion',
                        'fecha_notificacion'
                    ])
                    ->withTimestamps();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopeProgramadas($query)
    {
        return $query->where('estado', 'programada');
    }

    public function scopeEnCurso($query)
    {
        return $query->where('estado', 'en_curso');
    }

    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    public function scopeProximas($query)
    {
        return $query->where('estado', 'programada')
                     ->where('fecha_inicio', '>=', now())
                     ->orderBy('fecha_inicio', 'asc');
    }

    // Accesores
    public function getCuposDisponiblesAttribute()
    {
        if (!$this->cupo_maximo) {
            return null;
        }

        $inscritos = $this->empleados()
                          ->whereIn('capacitacion_empleado.estado_asistencia', ['invitado', 'confirmado', 'asistio'])
                          ->count();

        return $this->cupo_maximo - $inscritos;
    }

    public function getInscritosCountAttribute()
    {
        return $this->empleados()
                    ->whereIn('capacitacion_empleado.estado_asistencia', ['invitado', 'confirmado', 'asistio'])
                    ->count();
    }

    public function getConfirmadosCountAttribute()
    {
        return $this->empleados()
                    ->where('capacitacion_empleado.estado_asistencia', 'confirmado')
                    ->count();
    }

    public function getAsistentesCountAttribute()
    {
        return $this->empleados()
                    ->where('capacitacion_empleado.estado_asistencia', 'asistio')
                    ->count();
    }

    public function getDuracionFormateadaAttribute()
    {
        if (!$this->duracion_horas) {
            return 'No especificada';
        }

        if ($this->duracion_horas < 1) {
            return ($this->duracion_horas * 60) . ' minutos';
        }

        return $this->duracion_horas . ' hora(s)';
    }

    public function getFechaFormateadaAttribute()
    {
        if ($this->fecha_inicio->isSameDay($this->fecha_fin)) {
            return $this->fecha_inicio->format('d/m/Y');
        }

        return $this->fecha_inicio->format('d/m/Y') . ' - ' . $this->fecha_fin->format('d/m/Y');
    }

    public function getHorarioFormateadoAttribute()
    {
        return Carbon::parse($this->hora_inicio)->format('H:i') . ' - ' . Carbon::parse($this->hora_fin)->format('H:i');
    }

    public function getCostoFormateadoAttribute()
    {
        if (!$this->costo) {
            return 'Gratuita';
        }

        return '$' . number_format($this->costo, 0, ',', '.');
    }

    public function getEstadoBadgeAttribute()
    {
        return match($this->estado) {
            'programada' => 'bg-blue-100 text-blue-800',
            'en_curso' => 'bg-green-100 text-green-800',
            'completada' => 'bg-gray-100 text-gray-800',
            'cancelada' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getEstadoTextoAttribute()
    {
        return match($this->estado) {
            'programada' => 'Programada',
            'en_curso' => 'En Curso',
            'completada' => 'Completada',
            'cancelada' => 'Cancelada',
            default => 'Desconocido'
        };
    }

    // Métodos de utilidad
    public function tieneCuposDisponibles()
    {
        if (!$this->cupo_maximo) {
            return true;
        }

        return $this->cupos_disponibles > 0;
    }

    public function empleadoInscrito(Empleado $empleado)
    {
        return $this->empleados()
                    ->where('empleado_id', $empleado->id)
                    ->whereIn('capacitacion_empleado.estado_asistencia', ['invitado', 'confirmado', 'asistio'])
                    ->exists();
    }

    public function puedeSerModificada()
    {
        return $this->estado !== 'completada' && $this->estado !== 'cancelada';
    }

    public function puedeSerCancelada()
    {
        return $this->estado === 'programada' || $this->estado === 'en_curso';
    }

    public function puedeIniciar()
    {
        return $this->estado === 'programada' && $this->fecha_inicio->isToday();
    }

    public function puedeCompletar()
    {
        return $this->estado === 'en_curso' || ($this->estado === 'programada' && $this->fecha_fin->isPast());
    }
}
