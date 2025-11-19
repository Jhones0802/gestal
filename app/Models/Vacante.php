<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vacante extends Model
{
    use HasFactory;

    protected $fillable = [
    'titulo',
    'descripcion',
    'area',
    'ubicacion',
    'salario_minimo',
    'salario_maximo',
    'tipo_contrato',
    'modalidad',
    'experiencia_requerida',
    'nivel_educativo',
    'habilidades_requeridas',
    'responsabilidades',
    'requisitos',           // Added
    'competencias',         // Added
    'beneficios',
    'fecha_cierre',
    'prioridad',
    'estado',
    'observaciones',
    'visualizaciones',
    'aplicaciones',
    'fecha_publicacion',
    'vacantes_disponibles', // Added
    'contacto_responsable', // Added
    'proceso_seleccion',    // Added
    'documentos_requeridos', // Added
    'created_by',
    'updated_by'
];

    protected $casts = [
        'fecha_publicacion' => 'date',
        'fecha_cierre' => 'date',
        'salario_minimo' => 'decimal:2',
        'salario_maximo' => 'decimal:2',
        'documentos_requeridos' => 'array',
    ];

    // Relaciones
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function candidatos()
    {
        return $this->hasMany(Candidato::class);
    }

    // Accessors
    public function getSalarioRangoAttribute()
    {
        return '$' . number_format($this->salario_minimo, 0, ',', '.') . ' - $' . number_format($this->salario_maximo, 0, ',', '.');
    }

    public function getDiasPublicadaAttribute()
    {
        return Carbon::parse($this->fecha_publicacion)->diffForHumans();
    }

    public function getDiasParaCierreAttribute()
    {
        if (!$this->fecha_cierre) {
            return null;
        }
        
        $dias = Carbon::now()->diffInDays($this->fecha_cierre, false);
        
        if ($dias < 0) {
            return 'Vencida hace ' . abs($dias) . ' días';
        } elseif ($dias == 0) {
            return 'Vence hoy';
        } else {
            return 'Vence en ' . $dias . ' días';
        }
    }

    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('estado', 'publicada')
                    ->where(function ($q) {
                        $q->whereNull('fecha_cierre')
                          ->orWhere('fecha_cierre', '>=', Carbon::today());
                    });
    }

    public function scopePorArea($query, $area)
    {
        return $query->where('area', $area);
    }

    public function scopeUrgentes($query)
    {
        return $query->where('prioridad', 'urgente');
    }
}