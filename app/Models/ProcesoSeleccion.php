<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProcesoSeleccion extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidato_id',
        'tipo_evaluacion',
        'fecha_programada',
        'hora_programada',
        'fecha_realizada',
        'estado',
        'puntaje',
        'puntaje_maximo',
        'resultado',
        'observaciones',
        'fortalezas',
        'debilidades',
        'recomendaciones',
        'entrevistador',
        'lugar_evaluacion',
        'competencias_evaluadas',
        'archivo_resultado',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'fecha_programada' => 'date',
        'fecha_realizada' => 'date',
        'competencias_evaluadas' => 'array',
    ];

    // Relaciones
    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Accessors
    public function getPorcentajeAttribute()
    {
        if (!$this->puntaje || !$this->puntaje_maximo) {
            return null;
        }
        return round(($this->puntaje / $this->puntaje_maximo) * 100, 1);
    }

    public function getTipoEvaluacionFormateadaAttribute()
    {
        $tipos = [
            'entrevista_inicial' => 'Entrevista Inicial',
            'prueba_psicotecnica' => 'Prueba Psicotécnica',
            'entrevista_tecnica' => 'Entrevista Técnica',
            'verificacion_referencias' => 'Verificación de Referencias',
            'examen_medico' => 'Examen Médico'
        ];
        
        return $tipos[$this->tipo_evaluacion] ?? $this->tipo_evaluacion;
    }
}