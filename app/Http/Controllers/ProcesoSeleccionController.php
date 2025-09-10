<?php

namespace App\Http\Controllers;

use App\Models\ProcesoSeleccion;
use App\Models\Candidato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcesoSeleccionController extends Controller
{
    public function index(Request $request)
    {
        $query = ProcesoSeleccion::with('candidato', 'candidato.vacante');

        // Filtros
        if ($request->filled('tipo_evaluacion')) {
            $query->where('tipo_evaluacion', $request->tipo_evaluacion);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('resultado')) {
            $query->where('resultado', $request->resultado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_programada', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_programada', '<=', $request->fecha_hasta);
        }

        $evaluaciones = $query->orderBy('fecha_programada', 'desc')->paginate(15);

        return view('seleccion.proceso.index', compact('evaluaciones'));
    }

    public function create(Request $request)
    {
        $candidato_id = $request->get('candidato_id');
        $candidato = null;
        
        if ($candidato_id) {
            $candidato = Candidato::with('vacante')->findOrFail($candidato_id);
        }
        
        // Solo mostrar candidatos que están en proceso
        $candidatos = Candidato::with('vacante')
            ->whereIn('estado', ['preseleccionado', 'entrevista_inicial', 'pruebas_psicotecnicas', 'entrevista_tecnica', 'verificacion_referencias'])
            ->orderBy('nombres')
            ->get();

        return view('seleccion.proceso.create', compact('candidatos', 'candidato'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'candidato_id' => 'required|exists:candidatos,id',
            'tipo_evaluacion' => 'required|in:entrevista_inicial,prueba_psicotecnica,entrevista_tecnica,verificacion_referencias,examen_medico',
            'fecha_programada' => 'required|date|after_or_equal:today',
            'hora_programada' => 'nullable|date_format:H:i',
            'entrevistador' => 'nullable|string|max:255',
            'lugar_evaluacion' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['estado'] = 'programada';
        $validated['resultado'] = 'pendiente';

        ProcesoSeleccion::create($validated);

        return redirect()->route('proceso-seleccion.index')
            ->with('success', 'Evaluación programada exitosamente.');
    }

    public function show(ProcesoSeleccion $procesoSeleccion)
    {
        $procesoSeleccion->load('candidato', 'candidato.vacante', 'createdBy', 'updatedBy');
        return view('seleccion.proceso.show', compact('procesoSeleccion'));
    }

    public function edit(ProcesoSeleccion $procesoSeleccion)
    {
        $candidatos = Candidato::with('vacante')
            ->whereIn('estado', ['preseleccionado', 'entrevista_inicial', 'pruebas_psicotecnicas', 'entrevista_tecnica', 'verificacion_referencias'])
            ->orderBy('nombres')
            ->get();

        return view('seleccion.proceso.edit', compact('procesoSeleccion', 'candidatos'));
    }

    public function update(Request $request, ProcesoSeleccion $procesoSeleccion)
    {
        $validated = $request->validate([
            'candidato_id' => 'required|exists:candidatos,id',
            'tipo_evaluacion' => 'required|in:entrevista_inicial,prueba_psicotecnica,entrevista_tecnica,verificacion_referencias,examen_medico',
            'fecha_programada' => 'required|date',
            'hora_programada' => 'nullable|date_format:H:i',
            'fecha_realizada' => 'nullable|date',
            'estado' => 'required|in:programada,realizada,cancelada,reprogramada',
            'puntaje' => 'nullable|integer|min:0|max:' . $request->puntaje_maximo,
            'puntaje_maximo' => 'required|integer|min:1',
            'resultado' => 'required|in:aprobado,rechazado,pendiente',
            'observaciones' => 'nullable|string',
            'fortalezas' => 'nullable|string',
            'debilidades' => 'nullable|string',
            'recomendaciones' => 'nullable|string',
            'entrevistador' => 'nullable|string|max:255',
            'lugar_evaluacion' => 'nullable|string|max:255',
        ]);

        $validated['updated_by'] = Auth::id();

        $procesoSeleccion->update($validated);

        // Si la evaluación se marca como realizada, actualizar el estado del candidato
        if ($validated['estado'] === 'realizada') {
            $this->actualizarEstadoCandidato($procesoSeleccion->candidato, $validated['tipo_evaluacion']);
        }

        return redirect()->route('proceso-seleccion.show', $procesoSeleccion)
            ->with('success', 'Evaluación actualizada exitosamente.');
    }

    public function destroy(ProcesoSeleccion $procesoSeleccion)
    {
        $procesoSeleccion->delete();

        return redirect()->route('proceso-seleccion.index')
            ->with('success', 'Evaluación eliminada exitosamente.');
    }

    // Método auxiliar para actualizar estado del candidato
    private function actualizarEstadoCandidato(Candidato $candidato, string $tipoEvaluacion)
    {
        $nuevoEstado = null;

        switch ($tipoEvaluacion) {
            case 'entrevista_inicial':
                $nuevoEstado = 'pruebas_psicotecnicas';
                break;
            case 'prueba_psicotecnica':
                $nuevoEstado = 'entrevista_tecnica';
                break;
            case 'entrevista_tecnica':
                $nuevoEstado = 'verificacion_referencias';
                break;
            case 'verificacion_referencias':
                // Verificar si todas las evaluaciones anteriores están aprobadas
                $evaluacionesAprobadas = $candidato->evaluaciones()
                    ->where('resultado', 'aprobado')
                    ->where('estado', 'realizada')
                    ->count();
                
                if ($evaluacionesAprobadas >= 3) { // entrevista + psicotécnica + técnica
                    $nuevoEstado = 'aprobado';
                }
                break;
        }

        if ($nuevoEstado) {
            $candidato->update([
                'estado' => $nuevoEstado,
                'updated_by' => Auth::id()
            ]);
        }
    }

    // Método para calificar una evaluación rápidamente
    public function calificar(Request $request, ProcesoSeleccion $procesoSeleccion)
    {
        $validated = $request->validate([
            'puntaje' => 'required|integer|min:0|max:' . $request->puntaje_maximo,
            'puntaje_maximo' => 'required|integer|min:1',
            'resultado' => 'required|in:aprobado,rechazado',
            'observaciones' => 'nullable|string',
        ]);

        $validated['estado'] = 'realizada';
        $validated['fecha_realizada'] = now()->toDateString();
        $validated['updated_by'] = Auth::id();

        $procesoSeleccion->update($validated);

        // Actualizar estado del candidato
        $this->actualizarEstadoCandidato($procesoSeleccion->candidato, $procesoSeleccion->tipo_evaluacion);

        return redirect()->back()
            ->with('success', 'Evaluación calificada exitosamente.');
    }
}