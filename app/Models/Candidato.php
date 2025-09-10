<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Candidato extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacante_id',
        'tipo_documento',        
        'numero_documento',      
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'genero',
        'telefono',
        'celular',
        'email',
        'direccion',
        'ciudad',
        'departamento',
        'nivel_educativo',
        'profesion',            
        'universidad',          
        'experiencia_anos',     
        'experiencia_area',     
        'titulo_obtenido',
        'institucion',
        'experiencia_laboral',
        'pretension_salarial',
        'salario_aspirado',     
        'disponibilidad_inmediata',
        'fecha_disponibilidad', 
        'hoja_vida_path',       
        'hoja_vida',           
        'carta_presentacion',   
        'documentos_adjuntos',
        'estado',
        'observaciones',
        'puntaje_total',
        'fecha_aplicacion',
        'origen_aplicacion',    
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_aplicacion' => 'date',
        'documentos_adjuntos' => 'array',
        'pretension_salarial' => 'decimal:2',
    ];

    // Relaciones
    public function vacante()
    {
        return $this->belongsTo(Vacante::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function evaluaciones()
    {
        return $this->hasMany(ProcesoSeleccion::class);
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    public function getEdadAttribute()
    {
        return Carbon::parse($this->fecha_nacimiento)->age;
    }

    public function getPretensionFormateadaAttribute()
    {
        return $this->pretension_salarial ? '$' . number_format($this->pretension_salarial, 0, ',', '.') : 'No especificada';
    }

    public function getDiasAplicacionAttribute()
    {
        return Carbon::parse($this->fecha_aplicacion)->diffForHumans();
    }

    // Métodos de estado
    public function puedeSerPreseleccionado()
    {
        return $this->estado === 'aplicado';
    }

    public function puedeSerEntrevistado()
    {
        return in_array($this->estado, ['preseleccionado', 'entrevista_inicial']);
    }

    public function puedeTomarPruebas()
    {
        return $this->estado === 'entrevista_inicial';
    }

    public function puedeSerContratado()
    {
        return $this->estado === 'aprobado';
    }

    // Scopes
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeActivos($query)
    {
        return $query->whereNotIn('estado', ['rechazado', 'contratado']);
    }
}