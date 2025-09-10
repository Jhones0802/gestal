<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\Vacante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidatoController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidato::with('vacante');

        // Filtros
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombres', 'like', "%{$buscar}%")
                  ->orWhere('apellidos', 'like', "%{$buscar}%")
                  ->orWhere('cedula', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('vacante_id')) {
            $query->where('vacante_id', $request->vacante_id);
        }

        $candidatos = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Obtener vacantes para el filtro
        $vacantes = Vacante::orderBy('titulo')->get();

        return view('seleccion.candidatos.index', compact('candidatos', 'vacantes'));
    }

    public function create(Request $request)
    {
        $vacante_id = $request->get('vacante_id');
        $vacante = null;
        
        if ($vacante_id) {
            $vacante = Vacante::findOrFail($vacante_id);
        }
        
        $vacantes = Vacante::where('estado', 'publicada')->orderBy('titulo')->get();
        
        return view('seleccion.candidatos.create', compact('vacantes', 'vacante'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vacante_id' => 'required|exists:vacantes,id',
            'cedula' => 'required|string|unique:candidatos,cedula',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:masculino,femenino',
            'telefono' => 'required|string|max:20',
            'celular' => 'nullable|string|max:20',
            'email' => 'required|email|unique:candidatos,email',
            'direccion' => 'required|string',
            'ciudad' => 'required|string|max:100',
            'departamento' => 'required|string|max:100',
            'nivel_educativo' => 'required|in:primaria,bachillerato,tecnico,tecnologo,profesional,especializacion,maestria,doctorado',
            'titulo_obtenido' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'experiencia_laboral' => 'nullable|string',
            'pretension_salarial' => 'nullable|numeric|min:0',
            'hoja_vida' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB max
            'observaciones' => 'nullable|string',
        ]);

        // Upload de hoja de vida
        if ($request->hasFile('hoja_vida')) {
            $file = $request->file('hoja_vida');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['hoja_vida_path'] = $file->storeAs('candidatos/hojas_vida', $filename, 'public');
        }

        $validated['created_by'] = Auth::id();
        $validated['fecha_aplicacion'] = now()->toDateString();
        $validated['estado'] = 'aplicado';

        $candidato = Candidato::create($validated);

        return redirect()->route('candidatos.show', $candidato)
            ->with('success', 'Candidato registrado exitosamente.');
    }

    public function show(Candidato $candidato)
    {
        $candidato->load('vacante', 'evaluaciones', 'createdBy');
        return view('seleccion.candidatos.show', compact('candidato'));
    }

    public function edit(Candidato $candidato)
    {
        $vacantes = Vacante::where('estado', 'publicada')->orderBy('titulo')->get();
        return view('seleccion.candidatos.edit', compact('candidato', 'vacantes'));
    }

    public function update(Request $request, Candidato $candidato)
    {
        $validated = $request->validate([
            'vacante_id' => 'required|exists:vacantes,id',
            'cedula' => 'required|string|unique:candidatos,cedula,' . $candidato->id,
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:masculino,femenino',
            'telefono' => 'required|string|max:20',
            'celular' => 'nullable|string|max:20',
            'email' => 'required|email|unique:candidatos,email,' . $candidato->id,
            'direccion' => 'required|string',
            'ciudad' => 'required|string|max:100',
            'departamento' => 'required|string|max:100',
            'nivel_educativo' => 'required|in:primaria,bachillerato,tecnico,tecnologo,profesional,especializacion,maestria,doctorado',
            'titulo_obtenido' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'experiencia_laboral' => 'nullable|string',
            'pretension_salarial' => 'nullable|numeric|min:0',
            'estado' => 'required|in:aplicado,preseleccionado,entrevista_inicial,pruebas_psicotecnicas,entrevista_tecnica,verificacion_referencias,aprobado,rechazado,contratado',
            'hoja_vida' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'observaciones' => 'nullable|string',
        ]);

        // Upload de nueva hoja de vida
        if ($request->hasFile('hoja_vida')) {
            // Eliminar archivo anterior si existe
            if ($candidato->hoja_vida_path) {
                Storage::disk('public')->delete($candidato->hoja_vida_path);
            }
            
            $file = $request->file('hoja_vida');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['hoja_vida_path'] = $file->storeAs('candidatos/hojas_vida', $filename, 'public');
        }

        $validated['updated_by'] = Auth::id();

        $candidato->update($validated);

        return redirect()->route('candidatos.show', $candidato)
            ->with('success', 'Candidato actualizado exitosamente.');
    }

    public function destroy(Candidato $candidato)
    {
        // Eliminar archivo de hoja de vida si existe
        if ($candidato->hoja_vida_path) {
            Storage::disk('public')->delete($candidato->hoja_vida_path);
        }

        $candidato->delete();

        return redirect()->route('candidatos.index')
            ->with('success', 'Candidato eliminado exitosamente.');
    }

    // Métodos adicionales para cambiar estado
    public function cambiarEstado(Request $request, Candidato $candidato)
    {
        $validated = $request->validate([
            'nuevo_estado' => 'required|in:aplicado,preseleccionado,entrevista_inicial,pruebas_psicotecnicas,entrevista_tecnica,verificacion_referencias,aprobado,rechazado,contratado',
            'observaciones' => 'nullable|string'
        ]);

        $candidato->update([
            'estado' => $validated['nuevo_estado'],
            'observaciones' => $validated['observaciones'],
            'updated_by' => Auth::id()
        ]);

        return redirect()->back()
            ->with('success', 'Estado del candidato actualizado exitosamente.');
    }
}