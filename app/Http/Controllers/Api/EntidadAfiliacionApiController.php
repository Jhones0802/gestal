<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Afiliacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EntidadAfiliacionApiController extends Controller
{
    /**
     * Simula el envío de una solicitud de afiliación a una entidad externa
     * POST /api/entidades/afiliaciones
     */
    public function enviarSolicitud(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'afiliacion_id' => 'required|exists:afiliaciones,id',
            'entidad_tipo' => 'required|in:eps,arl,caja_compensacion,fondo_pensiones',
            'empleado' => 'required|array',
            'empleado.nombres' => 'required|string',
            'empleado.apellidos' => 'required|string',
            'empleado.cedula' => 'required|string',
            'empleado.fecha_nacimiento' => 'required|date',
            'documentos' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        // Simular procesamiento
        sleep(1); // Simular latencia de red

        // Generar respuesta simulada
        $numeroRadicado = $this->generarNumeroRadicado($request->entidad_tipo);
        $fechaRespuestaEstimada = now()->addDays(rand(5, 15))->format('Y-m-d');

        // Registrar en log
        \Log::info('API Entidad - Solicitud recibida', [
            'afiliacion_id' => $request->afiliacion_id,
            'entidad_tipo' => $request->entidad_tipo,
            'numero_radicado' => $numeroRadicado,
            'empleado' => $request->empleado['nombres'] . ' ' . $request->empleado['apellidos']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Solicitud de afiliación recibida exitosamente',
            'data' => [
                'numero_radicado' => $numeroRadicado,
                'estado' => 'recibida',
                'fecha_recepcion' => now()->format('Y-m-d H:i:s'),
                'fecha_respuesta_estimada' => $fechaRespuestaEstimada,
                'entidad' => [
                    'nombre' => $this->obtenerNombreEntidad($request->entidad_tipo),
                    'codigo' => $this->generarCodigoEntidad($request->entidad_tipo),
                    'contacto' => $this->obtenerContactoEntidad($request->entidad_tipo)
                ],
                'documentos_recibidos' => count($request->documentos),
                'observaciones' => 'Su solicitud está siendo procesada. Recibirá notificación cuando sea aprobada.'
            ]
        ], 201);
    }

    /**
     * Consultar estado de una afiliación en la entidad
     * GET /api/entidades/afiliaciones/{numero_radicado}
     */
    public function consultarEstado($numeroRadicado)
    {
        // Simular consulta
        sleep(1);

        // Buscar afiliación por número de radicado
        $afiliacion = Afiliacion::where('numero_radicado', $numeroRadicado)->first();

        if (!$afiliacion) {
            return response()->json([
                'success' => false,
                'message' => 'Número de radicado no encontrado',
                'codigo_error' => 'RADICADO_NO_EXISTE'
            ], 404);
        }

        // Simular diferentes estados según el tiempo transcurrido
        $estado = $this->simularEstadoProceso($afiliacion);

        \Log::info('API Entidad - Consulta de estado', [
            'numero_radicado' => $numeroRadicado,
            'estado' => $estado['estado']
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'numero_radicado' => $numeroRadicado,
                'estado' => $estado['estado'],
                'estado_descripcion' => $estado['descripcion'],
                'fecha_actualizacion' => now()->format('Y-m-d H:i:s'),
                'progreso' => $estado['progreso'],
                'siguiente_paso' => $estado['siguiente_paso'],
                'documentos_adicionales_requeridos' => $estado['documentos_adicionales'] ?? []
            ]
        ], 200);
    }

    /**
     * Simula la aprobación y emisión del certificado
     * POST /api/entidades/afiliaciones/{numero_radicado}/aprobar
     */
    public function aprobarAfiliacion(Request $request, $numeroRadicado)
    {
        $afiliacion = Afiliacion::where('numero_radicado', $numeroRadicado)->first();

        if (!$afiliacion) {
            return response()->json([
                'success' => false,
                'message' => 'Número de radicado no encontrado'
            ], 404);
        }

        // Simular aprobación
        sleep(2);

        $numeroAfiliado = $this->generarNumeroAfiliado($afiliacion->entidad_tipo);

        \Log::info('API Entidad - Afiliación aprobada', [
            'numero_radicado' => $numeroRadicado,
            'numero_afiliado' => $numeroAfiliado
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Afiliación aprobada exitosamente',
            'data' => [
                'numero_radicado' => $numeroRadicado,
                'numero_afiliado' => $numeroAfiliado,
                'estado' => 'aprobada',
                'fecha_aprobacion' => now()->format('Y-m-d H:i:s'),
                'fecha_afiliacion_efectiva' => now()->format('Y-m-d'),
                'vigencia' => 'indefinida',
                'certificado_url' => route('afiliaciones.certificado', $afiliacion->id),
                'entidad' => [
                    'nombre' => $afiliacion->entidad_nombre,
                    'nit' => $this->generarNIT(),
                    'codigo_habilitacion' => $this->generarCodigoEntidad($afiliacion->entidad_tipo)
                ]
            ]
        ], 200);
    }

    /**
     * Webhook simulado - La entidad notifica cambios de estado
     * POST /api/entidades/webhook/estado
     */
    public function webhookEstado(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_radicado' => 'required|string',
            'estado' => 'required|string',
            'observaciones' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        \Log::info('API Entidad - Webhook recibido', $request->all());

        return response()->json([
            'success' => true,
            'message' => 'Notificación recibida y procesada',
            'timestamp' => now()->toISOString()
        ], 200);
    }

    // Métodos auxiliares
    private function generarNumeroRadicado($tipoEntidad): string
    {
        $prefijo = strtoupper(substr($tipoEntidad, 0, 3));
        $fecha = now()->format('Ymd');
        $aleatorio = rand(1000, 9999);
        return "{$prefijo}-{$fecha}-{$aleatorio}";
    }

    private function generarNumeroAfiliado($tipoEntidad): string
    {
        $prefijo = strtoupper(substr($tipoEntidad, 0, 2));
        $timestamp = now()->format('ymd');
        $aleatorio = rand(100000, 999999);
        return "{$prefijo}{$timestamp}{$aleatorio}";
    }

    private function generarCodigoEntidad($tipoEntidad): string
    {
        $codigos = [
            'eps' => 'EPS' . rand(1000, 9999),
            'arl' => 'ARL' . rand(1000, 9999),
            'caja_compensacion' => 'CCF' . rand(1000, 9999),
            'fondo_pensiones' => 'FPN' . rand(1000, 9999)
        ];
        return $codigos[$tipoEntidad] ?? 'ENT' . rand(1000, 9999);
    }

    private function generarNIT(): string
    {
        return rand(800000000, 900000000) . '-' . rand(0, 9);
    }

    private function obtenerNombreEntidad($tipoEntidad): string
    {
        $nombres = [
            'eps' => ['Sura EPS', 'Salud Total', 'Nueva EPS', 'Sanitas'],
            'arl' => ['Sura ARL', 'Positiva ARL', 'Colmena ARL'],
            'caja_compensacion' => ['Compensar', 'Colsubsidio', 'Cafam'],
            'fondo_pensiones' => ['Protección', 'Porvenir', 'Colfondos']
        ];
        $opciones = $nombres[$tipoEntidad] ?? ['Entidad Genérica'];
        return $opciones[array_rand($opciones)];
    }

    private function obtenerContactoEntidad($tipoEntidad): array
    {
        return [
            'telefono' => '601-' . rand(3000000, 3999999),
            'email' => 'afiliaciones@' . strtolower($tipoEntidad) . '.com.co',
            'linea_atencion' => '018000-' . rand(100000, 999999)
        ];
    }

    private function simularEstadoProceso($afiliacion): array
    {
        $diasTranscurridos = now()->diffInDays($afiliacion->created_at);

        if ($diasTranscurridos < 2) {
            return [
                'estado' => 'en_revision',
                'descripcion' => 'Documentos en revisión inicial',
                'progreso' => 25,
                'siguiente_paso' => 'Verificación de documentos'
            ];
        } elseif ($diasTranscurridos < 5) {
            return [
                'estado' => 'verificacion_documentos',
                'descripcion' => 'Verificando autenticidad de documentos',
                'progreso' => 50,
                'siguiente_paso' => 'Validación de datos'
            ];
        } elseif ($diasTranscurridos < 8) {
            return [
                'estado' => 'procesamiento',
                'descripcion' => 'Procesando solicitud de afiliación',
                'progreso' => 75,
                'siguiente_paso' => 'Aprobación final'
            ];
        } else {
            return [
                'estado' => 'lista_para_aprobar',
                'descripcion' => 'Solicitud lista para aprobación',
                'progreso' => 90,
                'siguiente_paso' => 'Emisión de certificado'
            ];
        }
    }
}