<?php

namespace App\Http\Controllers;

use App\Models\Afiliacion;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\AfiliacionNotificacion;
use Illuminate\Support\Facades\Mail;
use App\Services\CertificadoPDFService;


class AfiliacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Afiliacion::with(['empleado', 'createdBy']);

        // Filtros básicos por ahora
        $afiliaciones = $query->orderBy('created_at', 'desc')->paginate(15);
        $empleados = Empleado::orderBy('nombres')->get();
        
        // Estadísticas básicas
        $estadisticas = [
            'total' => Afiliacion::count(),
            'pendientes' => Afiliacion::where('estado', 'pendiente')->count(),
            'en_proceso' => Afiliacion::whereIn('estado', ['en_proceso', 'enviada'])->count(),
            'completadas' => Afiliacion::where('estado', 'completada')->count(),
            'vencidas' => 0, // Por ahora
        ];

        return view('afiliaciones.index', compact('afiliaciones', 'empleados', 'estadisticas'));
    }

    public function create(Request $request)
    {
        $empleado_id = $request->get('empleado_id');
        $empleado = null;
        
        if ($empleado_id) {
            $empleado = Empleado::findOrFail($empleado_id);
        }
        
        $empleados = Empleado::orderBy('nombres')->get();
        
        // Entidades disponibles
        $entidades = [
            'eps' => [
                'label' => 'EPS',
                'opciones' => ['Sura EPS', 'Salud Total', 'Nueva EPS', 'Sanitas', 'Compensar EPS']
            ],
            'arl' => [
                'label' => 'ARL', 
                'opciones' => ['Sura ARL', 'Positiva ARL', 'Colmena ARL', 'Liberty ARL', 'Bolívar ARL']
            ],
            'caja_compensacion' => [
                'label' => 'Caja de Compensación',
                'opciones' => ['Compensar', 'Colsubsidio', 'Cafam', 'Comfenalco', 'Comfacauca']
            ],
            'fondo_pensiones' => [
                'label' => 'Fondo de Pensiones',
                'opciones' => ['Protección', 'Porvenir', 'Colfondos', 'Old Mutual', 'Colpensiones']
            ]
        ];

        return view('afiliaciones.create', compact('empleados', 'empleado', 'entidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'entidades_seleccionadas' => 'required|array|min:1',
            'observaciones_generales' => 'nullable|string'
        ]);

        $empleado = \App\Models\Empleado::findOrFail($validated['empleado_id']);
        $afiliacionesCreadas = [];

        foreach ($validated['entidades_seleccionadas'] as $tipoEntidad) {
            $entidadData = $request->input("entidades.{$tipoEntidad}");
            
            if (!$entidadData || !isset($entidadData['nombre']) || empty($entidadData['nombre'])) {
                continue;
            }

            $existente = \App\Models\Afiliacion::where('empleado_id', $empleado->id)
                                ->where('entidad_tipo', $tipoEntidad)
                                ->whereIn('estado', ['pendiente', 'en_proceso', 'enviada', 'aprobada', 'completada'])
                                ->first();

            if ($existente) {
                continue;
            }

            try {
                $afiliacion = \App\Models\Afiliacion::create([
                    'empleado_id' => $empleado->id,
                    'entidad_tipo' => $tipoEntidad,
                    'entidad_nombre' => $entidadData['nombre'],
                    'estado' => 'pendiente',
                    'fecha_solicitud' => now()->toDateString(),
                    'documentos_requeridos' => \App\Models\Afiliacion::getDocumentosRequeridos($tipoEntidad),
                    'dias_respuesta_estimados' => $entidadData['dias_respuesta'] ?? 5,
                    'observaciones' => $validated['observaciones_generales'],
                    'created_by' => \Illuminate\Support\Facades\Auth::id()
                ]);

                $afiliacionesCreadas[] = $afiliacion;
            } catch (\Exception $e) {
                \Log::error('Error creando afiliación: ' . $e->getMessage());
                continue;
            }
        }

        if (empty($afiliacionesCreadas)) {
            return redirect()->back()
                        ->with('error', 'No se pudieron crear las afiliaciones.');
        }

        // Enviar notificación de inicio al empleado
        $this->enviarNotificacionInicio($empleado, collect($afiliacionesCreadas));

        return redirect()->route('afiliaciones.index')
                        ->with('success', 'Se crearon ' . count($afiliacionesCreadas) . ' solicitudes de afiliación exitosamente. Se ha enviado una notificación al empleado.');
    }

    public function show(Afiliacion $afiliacion)
    {
        return view('afiliaciones.show', compact('afiliacion'));
    }

    public function edit(Afiliacion $afiliacion)
    {
        return view('afiliaciones.edit', compact('afiliacion'));
    }

    public function update(Request $request, Afiliacion $afiliacion)
    {
        $estadoAnterior = $afiliacion->estado;
        
        $validated = $request->validate([
            'entidad_nombre' => 'required|string|max:255',
            'estado' => 'required|in:pendiente,en_proceso,enviada,aprobada,rechazada,completada',
            'numero_radicado' => 'nullable|string|max:255',
            'fecha_envio' => 'nullable|date',
            'fecha_respuesta' => 'nullable|date',
            'fecha_afiliacion_efectiva' => 'nullable|date',
            'numero_afiliado' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
            'motivo_rechazo' => 'nullable|string',
            'dias_respuesta_estimados' => 'nullable|integer|min:1|max:30'
        ]);

        $validated['updated_by'] = \Illuminate\Support\Facades\Auth::id();

        if ($validated['estado'] === 'enviada' && !$validated['numero_radicado']) {
            $validated['numero_radicado'] = $afiliacion->generarNumeroRadicado();
            $validated['fecha_envio'] = $validated['fecha_envio'] ?? now()->toDateString();
        }

        if ($validated['estado'] === 'completada' && !$validated['numero_afiliado']) {
            $validated['numero_afiliado'] = $afiliacion->generarNumeroAfiliado();
            $validated['fecha_afiliacion_efectiva'] = $validated['fecha_afiliacion_efectiva'] ?? now()->toDateString();
        }

        $afiliacion->update($validated);

        if ($afiliacion->fecha_envio && $afiliacion->dias_respuesta_estimados) {
            $afiliacion->fecha_respuesta_estimada = $afiliacion->fecha_envio->copy()->addDays((int) $afiliacion->dias_respuesta_estimados);
            $afiliacion->save();
        }

        // AGREGAR ESTA LÓGICA PARA GENERAR PDF CUANDO SE COMPLETA
        if ($validated['estado'] === 'completada' && $estadoAnterior !== 'completada') {
            $pdfService = new CertificadoPDFService();
            $pdfService->generarCertificadoAutomatico($afiliacion);
        }


        // Enviar notificación si cambió el estado
        if ($estadoAnterior !== $validated['estado']) {
            if ($validated['estado'] === 'completada') {
                // Para completada, enviar email específico con PDF
                $this->enviarNotificacionCompletada($afiliacion);
            } else {
                // Para otros estados, email normal de actualización
                $this->enviarNotificacionActualizacion($afiliacion);
            }
        }

        return redirect()->route('afiliaciones.show', $afiliacion)
                        ->with('success', 'Afiliación actualizada exitosamente. Se ha notificado al empleado sobre el cambio.');
    }

    public function destroy(Afiliacion $afiliacion)
    {
        return redirect()->route('afiliaciones.index')
                        ->with('success', 'Funcionalidad en desarrollo.');
    }

    public function dashboard()
    {
        $estadisticas = $this->getEstadisticas();
        
        // Afiliaciones recientes (últimas 10)
        $afiliacionesRecientes = Afiliacion::with('empleado')
                                        ->orderBy('created_at', 'desc')
                                        ->take(10)
                                        ->get();
        
        // Alertas - afiliaciones próximas a vencer o vencidas
        $alertas = Afiliacion::with('empleado')
                            ->where('fecha_respuesta_estimada', '<=', now()->addDays(2))
                            ->whereIn('estado', ['enviada', 'en_proceso'])
                            ->orderBy('fecha_respuesta_estimada', 'asc')
                            ->get();

        return view('afiliaciones.dashboard', compact('estadisticas', 'afiliacionesRecientes', 'alertas'));
    }

    private function getEstadisticas()
    {
        return [
            'total' => Afiliacion::count(),
            'pendientes' => Afiliacion::where('estado', 'pendiente')->count(),
            'en_proceso' => Afiliacion::whereIn('estado', ['en_proceso', 'enviada'])->count(),
            'completadas' => Afiliacion::where('estado', 'completada')->count(),
            'vencidas' => Afiliacion::where('fecha_respuesta_estimada', '<=', now())
                                    ->whereIn('estado', ['enviada', 'en_proceso'])
                                    ->count(),
            'por_entidad' => [
                'eps' => Afiliacion::where('entidad_tipo', 'eps')->count(),
                'arl' => Afiliacion::where('entidad_tipo', 'arl')->count(),
                'caja_compensacion' => Afiliacion::where('entidad_tipo', 'caja_compensacion')->count(),
                'fondo_pensiones' => Afiliacion::where('entidad_tipo', 'fondo_pensiones')->count(),
            ]
        ];
    }

        
     //Enviar notificación por email
     
    private function enviarNotificacion(Empleado $empleado, string $tipo, $afiliaciones = null, Afiliacion $afiliacion = null)
    {
        try {
            Mail::to($empleado->email)->send(new AfiliacionNotificacion($empleado, $tipo, $afiliaciones, $afiliacion));
            
            // Marcar como enviada si es una afiliación específica
            if ($afiliacion) {
                $afiliacion->update([
                    'notificacion_empleado_enviada' => true,
                    'fecha_ultima_notificacion' => now()
                ]);
            }
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Error enviando notificación: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar notificación de inicio de proceso
     */
    public function enviarNotificacionInicio(Empleado $empleado, $afiliaciones)
    {
        return $this->enviarNotificacion($empleado, 'inicio', $afiliaciones);
    }

    /**
     * Enviar notificación de actualización
     */
    public function enviarNotificacionActualizacion(Afiliacion $afiliacion)
    {
        return $this->enviarNotificacion($afiliacion->empleado, 'actualizacion', null, $afiliacion);
    }

    public function completar(Afiliacion $afiliacion)
    {
        if (!$afiliacion->puedeCompletarse()) {
            return redirect()->back()
                        ->with('error', 'La afiliación no puede completarse desde su estado actual.');
        }

        $afiliacion->update([
            'estado' => 'completada',
            'numero_afiliado' => $afiliacion->generarNumeroAfiliado(),
            'fecha_afiliacion_efectiva' => now()->toDateString(),
            'fecha_respuesta' => now()->toDateString(),
            'updated_by' => \Illuminate\Support\Facades\Auth::id()
        ]);

        // Generar certificado PDF
        $pdfService = new CertificadoPDFService();
        $pdfService->generarCertificadoAutomatico($afiliacion);

        // Enviar notificación al empleado
        $this->enviarNotificacionActualizacion($afiliacion);

        return redirect()->back()
                        ->with('success', 'Afiliación completada exitosamente. Se ha generado el certificado y notificado al empleado.');
    }
    public function descargarCertificado(Afiliacion $afiliacion)
    {
        if (!$afiliacion->certificado_afiliacion) {
            return redirect()->back()
                        ->with('error', 'Esta afiliación no tiene certificado generado.');
        }

        $rutaArchivo = storage_path('app/public/' . $afiliacion->certificado_afiliacion);
        
        if (!file_exists($rutaArchivo)) {
            return redirect()->back()
                        ->with('error', 'El archivo del certificado no se encuentra.');
        }

        return response()->download($rutaArchivo);
    }

    public function enviarNotificacionCompletada(Afiliacion $afiliacion)
    {
        return $this->enviarNotificacion($afiliacion->empleado, 'completada', null, $afiliacion);
    }
}