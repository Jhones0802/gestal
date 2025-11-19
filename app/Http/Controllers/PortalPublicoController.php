<?php

namespace App\Http\Controllers;

use App\Models\Vacante;
use App\Models\Candidato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortalPublicoController extends Controller
{
    /**
     * Mostrar página principal con vacantes activas
     */
    public function index(Request $request)
    {
        $query = Vacante::where('estado', 'publicada')
                        ->where(function($q) {
                            $q->whereNull('fecha_cierre')
                              ->orWhere('fecha_cierre', '>=', now()->toDateString());
                        });

        // Filtros públicos
        if ($request->filled('area')) {
            $query->where('area', 'like', '%' . $request->area . '%');
        }

        if ($request->filled('ubicacion')) {
            $query->where('ubicacion', 'like', '%' . $request->ubicacion . '%');
        }

        if ($request->filled('tipo_contrato')) {
            $query->where('tipo_contrato', $request->tipo_contrato);
        }

        if ($request->filled('modalidad')) {
            $query->where('modalidad', $request->modalidad);
        }

        $vacantes = $query->orderBy('fecha_publicacion', 'desc')->paginate(12);
        
        // Obtener opciones para filtros
        $areas = Vacante::where('estado', 'publicada')
                        ->distinct()
                        ->pluck('area')
                        ->filter()
                        ->sort()
                        ->values();

        $ubicaciones = Vacante::where('estado', 'publicada')
                             ->distinct()
                             ->pluck('ubicacion')
                             ->filter()
                             ->sort()
                             ->values();

        return view('portal.index', compact('vacantes', 'areas', 'ubicaciones'));
    }

    /**
     * Mostrar detalle de una vacante específica
     */
    public function show(Vacante $vacante)
    {
        // Verificar que la vacante esté publicada y activa
        if ($vacante->estado !== 'publicada' ||
            ($vacante->fecha_cierre && $vacante->fecha_cierre < now()->toDateString())) {
            abort(404, 'Esta vacante ya no está disponible');
        }

        // Incrementar contador de visualizaciones
        $vacante->increment('visualizaciones');

        return view('portal.vacante', compact('vacante'));
    }

    /**
     * Mostrar formulario de aplicación
     */
    public function aplicar(Vacante $vacante)
    {
        // Verificar que la vacante esté disponible
        if ($vacante->estado !== 'publicada' ||
            ($vacante->fecha_cierre && $vacante->fecha_cierre < now()->toDateString())) {
            return redirect()->route('portal.index')
                           ->with('error', 'Esta vacante ya no está disponible para aplicaciones.');
        }

        return view('portal.aplicar', compact('vacante'));
    }

    /**
     * Procesar aplicación del candidato
     */
    public function store(Request $request, Vacante $vacante)
    {
        // Verificar que la vacante esté disponible
        if ($vacante->estado !== 'publicada' ||
            ($vacante->fecha_cierre && $vacante->fecha_cierre < now()->toDateString())) {
            return redirect()->route('portal.index')
                           ->with('error', 'Esta vacante ya no está disponible para aplicaciones.');
        }

        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'tipo_documento' => 'required|in:cedula,cedula_extranjeria,pasaporte',
            'numero_documento' => 'required|string|max:20|unique:candidatos,numero_documento',
            'email' => 'required|email|max:255|unique:candidatos,email',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date|before:' . now()->subYears(16)->toDateString(),
            'genero' => 'required|in:masculino,femenino,otro,prefiero_no_decir',
            'nivel_educativo' => 'required|in:primaria,secundaria,tecnico,tecnologo,universitario,posgrado',
            'profesion' => 'nullable|string|max:255',
            'universidad' => 'nullable|string|max:255',
            'experiencia_anos' => 'required|integer|min:0|max:50',
            'experiencia_area' => 'nullable|string',
            'salario_aspirado' => 'nullable|integer|min:0',
            'disponibilidad_inmediata' => 'required|boolean',
            'fecha_disponibilidad' => 'nullable|date|after_or_equal:today',
            'hoja_vida' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB
            'carta_presentacion' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // 2MB
            'observaciones' => 'nullable|string',
            'acepta_terminos' => 'required|accepted',
            'acepta_datos' => 'required|accepted'
        ], [
            'numero_documento.unique' => 'Ya existe un candidato registrado con este número de documento.',
            'email.unique' => 'Ya existe un candidato registrado con este email.',
            'fecha_nacimiento.before' => 'Debe ser mayor de 16 años para aplicar.',
            'hoja_vida.required' => 'La hoja de vida es obligatoria.',
            'hoja_vida.mimes' => 'La hoja de vida debe ser un archivo PDF, DOC o DOCX.',
            'hoja_vida.max' => 'La hoja de vida no puede superar los 5MB.',
            'acepta_terminos.accepted' => 'Debe aceptar los términos y condiciones.',
            'acepta_datos.accepted' => 'Debe autorizar el tratamiento de datos personales.'
        ]);

        // Manejar upload de archivos
        $archivoHojaVida = null;
        $archivoCarta = null;

        if ($request->hasFile('hoja_vida')) {
            $archivo = $request->file('hoja_vida');
            $nombreArchivo = time() . '_' . Str::slug($validated['nombres'] . '_' . $validated['apellidos']) . '_hv.' . $archivo->getClientOriginalExtension();
            $archivoHojaVida = $archivo->storeAs('candidatos/hojas_vida', $nombreArchivo, 'public');
        }

        if ($request->hasFile('carta_presentacion')) {
            $archivo = $request->file('carta_presentacion');
            $nombreArchivo = time() . '_' . Str::slug($validated['nombres'] . '_' . $validated['apellidos']) . '_carta.' . $archivo->getClientOriginalExtension();
            $archivoCarta = $archivo->storeAs('candidatos/cartas', $nombreArchivo, 'public');
        }

        // Crear candidato con estado 'aplicado'
        $candidato = Candidato::create([
            'vacante_id' => $vacante->id,
            'nombres' => $validated['nombres'],
            'apellidos' => $validated['apellidos'],
            'tipo_documento' => $validated['tipo_documento'],
            'numero_documento' => $validated['numero_documento'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'],
            'direccion' => $validated['direccion'],
            'ciudad' => $validated['ciudad'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'genero' => $validated['genero'],
            'nivel_educativo' => $validated['nivel_educativo'],
            'profesion' => $validated['profesion'],
            'universidad' => $validated['universidad'],
            'experiencia_anos' => $validated['experiencia_anos'],
            'experiencia_area' => $validated['experiencia_area'],
            'salario_aspirado' => $validated['salario_aspirado'],
            'disponibilidad_inmediata' => $validated['disponibilidad_inmediata'],
            'fecha_disponibilidad' => $validated['fecha_disponibilidad'],
            'hoja_vida' => $archivoHojaVida,
            'carta_presentacion' => $archivoCarta,
            'observaciones' => $validated['observaciones'],
            'estado' => 'aplicado',
            'fecha_aplicacion' => now(),
            'origen_aplicacion' => 'portal_publico'
        ]);

        // Incrementar contador de aplicaciones de la vacante
        $vacante->increment('aplicaciones');

        return view('portal.confirmacion', [
            'candidato' => $candidato,
            'vacante' => $vacante
        ]);
    }

    /**
     * Página de confirmación
     */
    public function confirmacion()
    {
        return redirect()->route('portal.index')
                        ->with('success', 'Su aplicación ha sido enviada exitosamente.');
    }

    /**
     * Consultar estado de aplicación
     */
    public function consultarEstado(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'numero_documento' => 'required|string',
                'email' => 'required|email'
            ]);

            $candidato = Candidato::where('numero_documento', $validated['numero_documento'])
                                 ->where('email', $validated['email'])
                                 ->with('vacante')
                                 ->first();

            if (!$candidato) {
                return back()->withErrors([
                    'consulta' => 'No se encontró ninguna aplicación con los datos proporcionados.'
                ]);
            }

            return view('portal.estado', compact('candidato'));
        }

        return view('portal.consultar');
    }

    /**
     * Búsqueda de vacantes con AJAX
     */
    public function buscar(Request $request)
    {
        $query = Vacante::where('estado', 'publicada')
                        ->where(function($q) {
                            $q->whereNull('fecha_cierre')
                              ->orWhere('fecha_cierre', '>=', now()->toDateString());
                        });

        if ($request->filled('q')) {
            $busqueda = $request->q;
            $query->where(function($q) use ($busqueda) {
                $q->where('titulo', 'like', '%' . $busqueda . '%')
                  ->orWhere('descripcion', 'like', '%' . $busqueda . '%')
                  ->orWhere('area', 'like', '%' . $busqueda . '%')
                  ->orWhere('ubicacion', 'like', '%' . $busqueda . '%');
            });
        }

        $vacantes = $query->orderBy('fecha_publicacion', 'desc')->take(10)->get();

        return response()->json($vacantes);
    }
}