<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Empleado::query();

        // Filtros
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombres', 'like', "%{$buscar}%")
                  ->orWhere('apellidos', 'like', "%{$buscar}%")
                  ->orWhere('cedula', 'like', "%{$buscar}%")
                  ->orWhere('cargo', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        $empleados = $query->orderBy('nombres')->paginate(10);
        
        // Obtener áreas únicas para el filtro
        $areas = Empleado::distinct()->pluck('area')->sort();

        return view('empleados.index', compact('empleados', 'areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cedula' => 'required|string|unique:empleados,cedula',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:masculino,femenino',
            'estado_civil' => 'required|in:soltero,casado,union_libre,divorciado,viudo',
            'telefono' => 'required|string|max:20',
            'celular' => 'nullable|string|max:20',
            'email' => 'required|email|unique:empleados,email',
            'direccion' => 'required|string',
            'ciudad' => 'required|string|max:100',
            'departamento' => 'required|string|max:100',
            'cargo' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'salario' => 'required|numeric|min:0',
            'tipo_contrato' => 'required|in:indefinido,fijo,prestacion_servicios,temporal',
            'fecha_ingreso' => 'required|date',
            'fecha_fin_contrato' => 'nullable|date|after:fecha_ingreso',
            'jefe_inmediato' => 'nullable|string|max:255',
            'eps' => 'nullable|string|max:100',
            'arl' => 'nullable|string|max:100',
            'fondo_pension' => 'nullable|string|max:100',
            'caja_compensacion' => 'nullable|string|max:100',
            'nivel_educativo' => 'required|in:primaria,bachillerato,tecnico,tecnologo,profesional,especializacion,maestria,doctorado',
            'titulo_obtenido' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'contacto_emergencia_nombre' => 'required|string|max:255',
            'contacto_emergencia_telefono' => 'required|string|max:20',
            'contacto_emergencia_parentesco' => 'required|string|max:50',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['estado'] = 'activo';

        Empleado::create($validated);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'cedula' => 'required|string|unique:empleados,cedula,' . $empleado->id,
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:masculino,femenino',
            'estado_civil' => 'required|in:soltero,casado,union_libre,divorciado,viudo',
            'telefono' => 'required|string|max:20',
            'celular' => 'nullable|string|max:20',
            'email' => 'required|email|unique:empleados,email,' . $empleado->id,
            'direccion' => 'required|string',
            'ciudad' => 'required|string|max:100',
            'departamento' => 'required|string|max:100',
            'cargo' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'salario' => 'required|numeric|min:0',
            'tipo_contrato' => 'required|in:indefinido,fijo,prestacion_servicios,temporal',
            'fecha_ingreso' => 'required|date',
            'fecha_fin_contrato' => 'nullable|date|after:fecha_ingreso',
            'estado' => 'required|in:activo,inactivo,liquidado',
            'jefe_inmediato' => 'nullable|string|max:255',
            'eps' => 'nullable|string|max:100',
            'arl' => 'nullable|string|max:100',
            'fondo_pension' => 'nullable|string|max:100',
            'caja_compensacion' => 'nullable|string|max:100',
            'nivel_educativo' => 'required|in:primaria,bachillerato,tecnico,tecnologo,profesional,especializacion,maestria,doctorado',
            'titulo_obtenido' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'contacto_emergencia_nombre' => 'required|string|max:255',
            'contacto_emergencia_telefono' => 'required|string|max:20',
            'contacto_emergencia_parentesco' => 'required|string|max:50',
        ]);

        $validated['updated_by'] = Auth::id();

        $empleado->update($validated);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        // Solo cambiar estado, no eliminar físicamente
        $empleado->update([
            'estado' => 'inactivo',
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado marcado como inactivo exitosamente.');
    }
}