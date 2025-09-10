<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'cedula',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'genero',
        'estado_civil',
        'telefono',
        'celular',
        'email',
        'direccion',
        'ciudad',
        'departamento',
        'cargo',
        'area',
        'salario',
        'tipo_contrato',
        'fecha_ingreso',
        'fecha_fin_contrato',
        'estado',
        'jefe_inmediato',
        'eps',
        'arl',
        'fondo_pension',
        'caja_compensacion',
        'nivel_educativo',
        'titulo_obtenido',
        'institucion',
        'contacto_emergencia_nombre',
        'contacto_emergencia_telefono',
        'contacto_emergencia_parentesco',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
        'fecha_fin_contrato' => 'date',
        'salario' => 'decimal:2',
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

    // Mutadores y Accesores
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    public function getEdadAttribute()
    {
        return Carbon::parse($this->fecha_nacimiento)->age;
    }

    public function getAntiguedadAttribute()
    {
        return Carbon::parse($this->fecha_ingreso)->diffForHumans(null, true);
    }

    public function getSalarioFormateadoAttribute()
    {
        return '$' . number_format($this->salario, 0, ',', '.');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopePorArea($query, $area)
    {
        return $query->where('area', $area);
    }

    public function scopePorCargo($query, $cargo)
    {
        return $query->where('cargo', $cargo);
    }

    public function afiliaciones()
    {
        return $this->hasMany(Afiliacion::class);
    }

    public function tieneAfiliacionCompleta(): bool
    {
        $tiposRequeridos = ['eps', 'arl', 'caja_compensacion', 'fondo_pensiones'];
        $completadas = $this->afiliaciones()->where('estado', 'completada')->pluck('entidad_tipo')->toArray();
        
        return count(array_intersect($tiposRequeridos, $completadas)) === count($tiposRequeridos);
    }

    public function getAfiliacionesPendientes()
    {
        return $this->afiliaciones()->pendientes()->get();
    }
}