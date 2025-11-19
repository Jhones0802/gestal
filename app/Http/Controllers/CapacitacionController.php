<?php

namespace App\Http\Controllers;

use App\Models\Capacitacion;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CapacitacionNotificacion;

class CapacitacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Capacitacion::with(['empleados', 'createdBy']);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fecha_inicio', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_fin', '<=', $request->fecha_hasta);
        }

        $capacitaciones = $query->orderBy('fecha_inicio', 'desc')->paginate(15);

        // Estadísticas
        $estadisticas = [
            'total' => Capacitacion::count(),
            'programadas' => Capacitacion::where('estado', 'programada')->count(),
            'en_curso' => Capacitacion::where('estado', 'en_curso')->count(),
            'completadas' => Capacitacion::where('estado', 'completada')->count(),
            'proximas' => Capacitacion::where('estado', 'programada')
                                      ->where('fecha_inicio', '>=', now())
                                      ->count(),
        ];

        return view('capacitaciones.index', compact('capacitaciones', 'estadisticas'));
    }

    public function create()
    {
        $empleados = Empleado::activos()->orderBy('nombres')->get();
        return view('capacitaciones.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $rules = [
            'titulo' => 'required|string|min:5|max:255',
            'descripcion' => 'required|string|min:10|max:1000',
            'tipo' => 'required|in:presencial,virtual,hibrida',
            'instructor' => 'required|string|min:3|max:255',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'duracion_horas' => 'required|numeric|min:0.5|max:24',
            'cupo_maximo' => 'required|integer|min:1|max:1000',
            'objetivos' => 'required|string|min:10|max:2000',
            'contenido' => 'required|string|min:10|max:5000',
            'requisitos' => 'nullable|string|max:1000',
            'materiales' => 'nullable|string|max:1000',
            'costo' => 'nullable|numeric|min:0|max:999999999',
            'certificado_tipo' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:1000',
            'empleados' => 'required|array|min:1',
            'empleados.*' => 'exists:empleados,id'
        ];

        // Validaciones condicionales según el tipo
        if ($request->tipo === 'presencial' || $request->tipo === 'hibrida') {
            $rules['lugar'] = 'required|string|max:255';
        } else {
            $rules['lugar'] = 'nullable|string|max:255';
        }

        if ($request->tipo === 'virtual' || $request->tipo === 'hibrida') {
            $rules['link_virtual'] = 'required|url|max:500';
        } else {
            $rules['link_virtual'] = 'nullable|url|max:500';
        }

        $messages = [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.min' => 'El título debe tener al menos 5 caracteres.',
            'titulo.max' => 'El título no puede exceder 255 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            'descripcion.max' => 'La descripción no puede exceder 1000 caracteres.',
            'tipo.required' => 'Debe seleccionar un tipo de capacitación.',
            'tipo.in' => 'El tipo de capacitación no es válido.',
            'instructor.required' => 'El nombre del instructor es obligatorio.',
            'instructor.min' => 'El nombre del instructor debe tener al menos 3 caracteres.',
            'instructor.max' => 'El nombre del instructor no puede exceder 255 caracteres.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.after_or_equal' => 'La fecha de inicio no puede ser anterior a hoy.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'El formato de la hora de inicio no es válido.',
            'hora_fin.required' => 'La hora de fin es obligatoria.',
            'hora_fin.date_format' => 'El formato de la hora de fin no es válido.',
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'duracion_horas.required' => 'La duración es obligatoria.',
            'duracion_horas.min' => 'La duración mínima es de 0.5 horas (30 minutos).',
            'duracion_horas.max' => 'La duración máxima es de 24 horas.',
            'cupo_maximo.required' => 'El cupo máximo es obligatorio.',
            'cupo_maximo.min' => 'El cupo máximo debe ser al menos 1.',
            'cupo_maximo.max' => 'El cupo máximo no puede exceder 1000.',
            'objetivos.required' => 'Los objetivos son obligatorios.',
            'objetivos.min' => 'Los objetivos deben tener al menos 10 caracteres.',
            'objetivos.max' => 'Los objetivos no pueden exceder 2000 caracteres.',
            'contenido.required' => 'El contenido es obligatorio.',
            'contenido.min' => 'El contenido debe tener al menos 10 caracteres.',
            'contenido.max' => 'El contenido no puede exceder 5000 caracteres.',
            'lugar.required' => 'El lugar es obligatorio para capacitaciones presenciales.',
            'link_virtual.required' => 'El link virtual es obligatorio para capacitaciones virtuales.',
            'link_virtual.url' => 'El link virtual debe ser una URL válida.',
            'costo.min' => 'El costo no puede ser negativo.',
            'empleados.required' => 'Debe seleccionar al menos un empleado.',
            'empleados.min' => 'Debe seleccionar al menos un empleado.',
            'empleados.*.exists' => 'Uno o más empleados seleccionados no son válidos.',
        ];

        $validated = $request->validate($rules, $messages);

        // Validación adicional: empleados invitados no deben superar el cupo
        if ($request->filled('empleados') && $request->filled('cupo_maximo')) {
            $cantidadEmpleados = count($request->empleados);
            if ($cantidadEmpleados > $request->cupo_maximo) {
                return back()->withErrors([
                    'empleados' => "Ha seleccionado {$cantidadEmpleados} empleados, pero el cupo máximo es de {$request->cupo_maximo}. Reduzca el número de empleados o aumente el cupo."
                ])->withInput();
            }
        }

        // Limpiar link_virtual si es presencial
        if ($request->tipo === 'presencial') {
            $validated['link_virtual'] = null;
        }

        // Limpiar lugar si es virtual
        if ($request->tipo === 'virtual') {
            $validated['lugar'] = null;
        }

        $validated['created_by'] = Auth::id();
        $validated['estado'] = 'programada';

        $capacitacion = Capacitacion::create($validated);

        // Inscribir empleados seleccionados
        if ($request->filled('empleados')) {
            $empleadosData = [];
            foreach ($request->empleados as $empleadoId) {
                $empleadosData[$empleadoId] = [
                    'estado_asistencia' => 'invitado',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            $capacitacion->empleados()->attach($empleadosData);

            // Enviar notificaciones a los empleados invitados
            $this->enviarNotificacionesInvitacion($capacitacion);
        }

        return redirect()->route('capacitaciones.index')
                        ->with('success', 'Capacitación creada exitosamente. Se han enviado las invitaciones a los empleados.');
    }

    public function show(Capacitacion $capacitacione)
    {
        $capacitacion = $capacitacione;
        $capacitacion->load(['empleados', 'createdBy', 'updatedBy']);

        return view('capacitaciones.show', compact('capacitacion'));
    }

    public function edit(Capacitacion $capacitacione)
    {
        $capacitacion = $capacitacione;

        if (!$capacitacion->puedeSerModificada()) {
            return redirect()->route('capacitaciones.show', $capacitacion)
                           ->with('error', 'Esta capacitación no puede ser modificada.');
        }

        $empleados = Empleado::activos()->orderBy('nombres')->get();
        $inscritosIds = $capacitacion->empleados()->pluck('empleado_id')->toArray();

        return view('capacitaciones.edit', compact('capacitacion', 'empleados', 'inscritosIds'));
    }

    public function update(Request $request, Capacitacion $capacitacione)
    {
        $capacitacion = $capacitacione;

        if (!$capacitacion->puedeSerModificada()) {
            return redirect()->route('capacitaciones.show', $capacitacion)
                           ->with('error', 'Esta capacitación no puede ser modificada.');
        }

        $rules = [
            'titulo' => 'required|string|min:5|max:255',
            'descripcion' => 'required|string|min:10|max:1000',
            'tipo' => 'required|in:presencial,virtual,hibrida',
            'instructor' => 'required|string|min:3|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'duracion_horas' => 'required|numeric|min:0.5|max:24',
            'cupo_maximo' => 'required|integer|min:1|max:1000',
            'estado' => 'required|in:programada,en_curso,completada,cancelada',
            'objetivos' => 'required|string|min:10|max:2000',
            'contenido' => 'required|string|min:10|max:5000',
            'requisitos' => 'nullable|string|max:1000',
            'materiales' => 'nullable|string|max:1000',
            'costo' => 'nullable|numeric|min:0|max:999999999',
            'certificado_tipo' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:1000',
            'empleados' => 'required|array|min:1',
            'empleados.*' => 'exists:empleados,id'
        ];

        // Validaciones condicionales según el tipo
        if ($request->tipo === 'presencial' || $request->tipo === 'hibrida') {
            $rules['lugar'] = 'required|string|max:255';
        } else {
            $rules['lugar'] = 'nullable|string|max:255';
        }

        if ($request->tipo === 'virtual' || $request->tipo === 'hibrida') {
            $rules['link_virtual'] = 'required|url|max:500';
        } else {
            $rules['link_virtual'] = 'nullable|url|max:500';
        }

        $messages = [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.min' => 'El título debe tener al menos 5 caracteres.',
            'titulo.max' => 'El título no puede exceder 255 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            'descripcion.max' => 'La descripción no puede exceder 1000 caracteres.',
            'tipo.required' => 'Debe seleccionar un tipo de capacitación.',
            'tipo.in' => 'El tipo de capacitación no es válido.',
            'instructor.required' => 'El nombre del instructor es obligatorio.',
            'instructor.min' => 'El nombre del instructor debe tener al menos 3 caracteres.',
            'instructor.max' => 'El nombre del instructor no puede exceder 255 caracteres.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'El formato de la hora de inicio no es válido.',
            'hora_fin.required' => 'La hora de fin es obligatoria.',
            'hora_fin.date_format' => 'El formato de la hora de fin no es válido.',
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'duracion_horas.required' => 'La duración es obligatoria.',
            'duracion_horas.min' => 'La duración mínima es de 0.5 horas (30 minutos).',
            'duracion_horas.max' => 'La duración máxima es de 24 horas.',
            'cupo_maximo.required' => 'El cupo máximo es obligatorio.',
            'cupo_maximo.min' => 'El cupo máximo debe ser al menos 1.',
            'cupo_maximo.max' => 'El cupo máximo no puede exceder 1000.',
            'objetivos.required' => 'Los objetivos son obligatorios.',
            'objetivos.min' => 'Los objetivos deben tener al menos 10 caracteres.',
            'objetivos.max' => 'Los objetivos no pueden exceder 2000 caracteres.',
            'contenido.required' => 'El contenido es obligatorio.',
            'contenido.min' => 'El contenido debe tener al menos 10 caracteres.',
            'contenido.max' => 'El contenido no puede exceder 5000 caracteres.',
            'lugar.required' => 'El lugar es obligatorio para capacitaciones presenciales.',
            'link_virtual.required' => 'El link virtual es obligatorio para capacitaciones virtuales.',
            'link_virtual.url' => 'El link virtual debe ser una URL válida.',
            'costo.min' => 'El costo no puede ser negativo.',
            'empleados.required' => 'Debe seleccionar al menos un empleado.',
            'empleados.min' => 'Debe seleccionar al menos un empleado.',
            'empleados.*.exists' => 'Uno o más empleados seleccionados no son válidos.',
        ];

        $validated = $request->validate($rules, $messages);

        // Validación adicional: empleados invitados no deben superar el cupo
        if ($request->filled('empleados') && $request->filled('cupo_maximo')) {
            $cantidadEmpleados = count($request->empleados);
            if ($cantidadEmpleados > $request->cupo_maximo) {
                return back()->withErrors([
                    'empleados' => "Ha seleccionado {$cantidadEmpleados} empleados, pero el cupo máximo es de {$request->cupo_maximo}. Reduzca el número de empleados o aumente el cupo."
                ])->withInput();
            }
        }

        // Limpiar link_virtual si es presencial
        if ($request->tipo === 'presencial') {
            $validated['link_virtual'] = null;
        }

        // Limpiar lugar si es virtual
        if ($request->tipo === 'virtual') {
            $validated['lugar'] = null;
        }

        $validated['updated_by'] = Auth::id();

        $capacitacion->update($validated);

        // Sincronizar empleados
        if ($request->has('empleados')) {
            $inscritosActuales = $capacitacion->empleados()->pluck('empleado_id')->toArray();
            $nuevosInscritos = array_diff($request->empleados ?? [], $inscritosActuales);

            $empleadosData = [];
            foreach ($request->empleados as $empleadoId) {
                if (in_array($empleadoId, $inscritosActuales)) {
                    continue; // Ya existe, no hacer nada
                }
                $empleadosData[$empleadoId] = [
                    'estado_asistencia' => 'invitado',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $capacitacion->empleados()->sync($request->empleados);

            // Notificar solo a los nuevos inscritos
            if (!empty($nuevosInscritos)) {
                $this->enviarNotificacionesInvitacion($capacitacion, $nuevosInscritos);
            }
        }

        return redirect()->route('capacitaciones.show', $capacitacion)
                        ->with('success', 'Capacitación actualizada exitosamente.');
    }

    public function destroy(Capacitacion $capacitacione)
    {
        $capacitacion = $capacitacione;

        if ($capacitacion->estado === 'completada') {
            return redirect()->route('capacitaciones.index')
                           ->with('error', 'No se puede eliminar una capacitación completada.');
        }

        $capacitacion->delete();

        return redirect()->route('capacitaciones.index')
                        ->with('success', 'Capacitación eliminada exitosamente.');
    }

    // Métodos adicionales para gestión de empleados
    public function inscribirEmpleado(Request $request, Capacitacion $capacitacion)
    {
        $validated = $request->validate([
            'empleado_id' => 'required|exists:empleados,id'
        ]);

        $empleado = Empleado::findOrFail($validated['empleado_id']);

        if ($capacitacion->empleadoInscrito($empleado)) {
            return back()->with('error', 'El empleado ya está inscrito en esta capacitación.');
        }

        if (!$capacitacion->tieneCuposDisponibles()) {
            return back()->with('error', 'No hay cupos disponibles para esta capacitación.');
        }

        $capacitacion->empleados()->attach($empleado->id, [
            'estado_asistencia' => 'invitado',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Enviar notificación al empleado
        $this->enviarNotificacionInvitacion($capacitacion, $empleado);

        return back()->with('success', 'Empleado inscrito exitosamente. Se ha enviado la invitación.');
    }

    public function actualizarAsistencia(Request $request, Capacitacion $capacitacion, Empleado $empleado)
    {
        $validated = $request->validate([
            'estado_asistencia' => 'required|in:invitado,confirmado,asistio,no_asistio,cancelado',
            'calificacion' => 'nullable|numeric|min:0|max:5',
            'comentarios' => 'nullable|string'
        ]);

        $capacitacion->empleados()->updateExistingPivot($empleado->id, $validated);

        return back()->with('success', 'Asistencia actualizada exitosamente.');
    }

    // Métodos de notificación
    private function enviarNotificacionesInvitacion(Capacitacion $capacitacion, $empleadosIds = null)
    {
        $empleados = $empleadosIds
            ? Empleado::whereIn('id', $empleadosIds)->get()
            : $capacitacion->empleados;

        foreach ($empleados as $empleado) {
            $this->enviarNotificacionInvitacion($capacitacion, $empleado);
        }

        $capacitacion->update([
            'notificacion_enviada' => true,
            'fecha_notificacion' => now()
        ]);
    }

    private function enviarNotificacionInvitacion(Capacitacion $capacitacion, Empleado $empleado)
    {
        try {
            Mail::to($empleado->email)->send(
                new CapacitacionNotificacion($capacitacion, $empleado, 'invitacion')
            );

            // Actualizar fecha de notificación en pivot
            $capacitacion->empleados()->updateExistingPivot($empleado->id, [
                'fecha_notificacion' => now()
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error('Error enviando notificación de capacitación: ' . $e->getMessage());
            return false;
        }
    }

    private function enviarNotificacionRecordatorio(Capacitacion $capacitacion, Empleado $empleado)
    {
        try {
            Mail::to($empleado->email)->send(
                new CapacitacionNotificacion($capacitacion, $empleado, 'recordatorio')
            );
            return true;
        } catch (\Exception $e) {
            \Log::error('Error enviando recordatorio de capacitación: ' . $e->getMessage());
            return false;
        }
    }

    private function enviarNotificacionCancelacion(Capacitacion $capacitacion, Empleado $empleado)
    {
        try {
            Mail::to($empleado->email)->send(
                new CapacitacionNotificacion($capacitacion, $empleado, 'cancelacion')
            );
            return true;
        } catch (\Exception $e) {
            \Log::error('Error enviando notificación de cancelación: ' . $e->getMessage());
            return false;
        }
    }

    // Acciones rápidas
    public function cancelar(Capacitacion $capacitacion)
    {
        if (!$capacitacion->puedeSerCancelada()) {
            return back()->with('error', 'Esta capacitación no puede ser cancelada.');
        }

        $capacitacion->update([
            'estado' => 'cancelada',
            'updated_by' => Auth::id()
        ]);

        // Notificar a todos los empleados inscritos
        foreach ($capacitacion->empleados as $empleado) {
            $this->enviarNotificacionCancelacion($capacitacion, $empleado);
        }

        return back()->with('success', 'Capacitación cancelada. Se ha notificado a todos los empleados.');
    }

    public function iniciar(Capacitacion $capacitacion)
    {
        if (!$capacitacion->puedeIniciar()) {
            return back()->with('error', 'Esta capacitación no puede iniciarse aún.');
        }

        $capacitacion->update([
            'estado' => 'en_curso',
            'updated_by' => Auth::id()
        ]);

        return back()->with('success', 'Capacitación iniciada exitosamente.');
    }

    public function completar(Capacitacion $capacitacion)
    {
        if (!$capacitacion->puedeCompletar()) {
            return back()->with('error', 'Esta capacitación no puede completarse aún.');
        }

        $capacitacion->update([
            'estado' => 'completada',
            'updated_by' => Auth::id()
        ]);

        return back()->with('success', 'Capacitación completada exitosamente.');
    }

    public function enviarRecordatorios(Capacitacion $capacitacion)
    {
        $empleados = $capacitacion->empleados()
                                  ->whereIn('capacitacion_empleado.estado_asistencia', ['invitado', 'confirmado'])
                                  ->get();

        $count = 0;
        foreach ($empleados as $empleado) {
            if ($this->enviarNotificacionRecordatorio($capacitacion, $empleado)) {
                $count++;
            }
        }

        return back()->with('success', "Se enviaron {$count} recordatorios exitosamente.");
    }
}
