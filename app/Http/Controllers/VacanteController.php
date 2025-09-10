<?php

namespace App\Http\Controllers;

use App\Models\Vacante;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacanteController extends Controller
{
    public function index(Request $request)
    {
        $query = Vacante::with('createdBy');

        // Filtros
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('area', 'like', "%{$buscar}%")
                  ->orWhere('ubicacion', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        $vacantes = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Obtener áreas únicas para el filtro
        $areas = Empleado::distinct()->pluck('area')->sort();

        return view('seleccion.vacantes.index', compact('vacantes', 'areas'));
    }

    public function create()
    {
        $areas = Empleado::distinct()->pluck('area')->sort();
        return view('seleccion.vacantes.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'area' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'responsabilidades' => 'required|string',
            'requisitos' => 'required|string',
            'competencias' => 'nullable|string',
            'salario_minimo' => 'required|numeric|min:0',
            'salario_maximo' => 'required|numeric|min:0|gte:salario_minimo',
            'tipo_contrato' => 'required|in:indefinido,fijo,prestacion_servicios,temporal',
            'modalidad' => 'required|in:presencial,remoto,hibrido',
            'ubicacion' => 'required|string|max:255',
            'vacantes_disponibles' => 'required|integer|min:1',
            'fecha_publicacion' => 'required|date',
            'fecha_cierre' => 'nullable|date|after:fecha_publicacion',
            'prioridad' => 'required|in:baja,media,alta,urgente',
            'contacto_responsable' => 'required|string|max:255',
            'proceso_seleccion' => 'nullable|string',
            'documentos_requeridos' => 'nullable|array',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['estado'] = 'borrador';

        Vacante::create($validated);

        return redirect()->route('vacantes.index')
            ->with('success', 'Vacante creada exitosamente.');
    }

    public function show(Vacante $vacante)
    {
        $vacante->load('candidatos', 'createdBy', 'updatedBy');
        return view('seleccion.vacantes.show', compact('vacante'));
    }

    public function edit(Vacante $vacante)
    {
        $areas = Empleado::distinct()->pluck('area')->sort();
        return view('seleccion.vacantes.edit', compact('vacante', 'areas'));
    }

    public function update(Request $request, Vacante $vacante)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'area' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'responsabilidades' => 'required|string',
            'requisitos' => 'required|string',
            'competencias' => 'nullable|string',
            'salario_minimo' => 'required|numeric|min:0',
            'salario_maximo' => 'required|numeric|min:0|gte:salario_minimo',
            'tipo_contrato' => 'required|in:indefinido,fijo,prestacion_servicios,temporal',
            'modalidad' => 'required|in:presencial,remoto,hibrido',
            'ubicacion' => 'required|string|max:255',
            'vacantes_disponibles' => 'required|integer|min:1',
            'fecha_publicacion' => 'required|date',
            'fecha_cierre' => 'nullable|date|after:fecha_publicacion',
            'estado' => 'required|in:borrador,publicada,cerrada,cancelada',
            'prioridad' => 'required|in:baja,media,alta,urgente',
            'contacto_responsable' => 'required|string|max:255',
            'proceso_seleccion' => 'nullable|string',
            'documentos_requeridos' => 'nullable|array',
        ]);

        $validated['updated_by'] = Auth::id();

        $vacante->update($validated);

        return redirect()->route('vacantes.index')
            ->with('success', 'Vacante actualizada exitosamente.');
    }

    public function destroy(Vacante $vacante)
    {
        // Solo cambiar estado, no eliminar físicamente
        $vacante->update([
            'estado' => 'cancelada',
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('vacantes.index')
            ->with('success', 'Vacante cancelada exitosamente.');
    }

    // Métodos adicionales para gestión de estado
    public function publicar(Vacante $vacante)
    {
        $vacante->update([
            'estado' => 'publicada',
            'fecha_publicacion' => now(), // Agregar esta línea
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('vacantes.index')
            ->with('success', 'Vacante publicada exitosamente.');
    }

    public function cerrar(Vacante $vacante)
    {
        $vacante->update([
            'estado' => 'cerrada',
            'fecha_cierre' => now()->toDateString(),
            'updated_by' => Auth::id()
        ]);

        return redirect()->back()
            ->with('success', 'Vacante cerrada exitosamente.');
    }
}