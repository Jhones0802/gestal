<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nomina;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PagoNominaApiController extends Controller
{
    /**
     * Enviar dispersión de nómina al banco
     * POST /api/banco/nomina/dispersar
     */
    public function dispersarNomina(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'empresa_nit' => 'required|string',
            'periodo' => 'required|string',
            'fecha_pago' => 'required|date',
            'cuenta_debito' => 'required|string',
            'empleados' => 'required|array|min:1',
            'empleados.*.cedula' => 'required|string',
            'empleados.*.nombres' => 'required|string',
            'empleados.*.apellidos' => 'required|string',
            'empleados.*.cuenta_bancaria' => 'required|string',
            'empleados.*.banco' => 'required|string',
            'empleados.*.tipo_cuenta' => 'required|in:ahorros,corriente',
            'empleados.*.valor' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        // Simular procesamiento bancario
        sleep(2);

        $loteId = $this->generarLoteId();
        $totalEmpleados = count($request->empleados);
        $montoTotal = collect($request->empleados)->sum('valor');

        // Simular validación de cada empleado
        $empleadosProcesados = [];
        $empleadosExitosos = 0;
        $empleadosFallidos = 0;

        foreach ($request->empleados as $empleado) {
            // 95% de probabilidad de éxito
            $exitoso = rand(1, 100) <= 95;
            
            if ($exitoso) {
                $empleadosProcesados[] = [
                    'cedula' => $empleado['cedula'],
                    'nombre_completo' => $empleado['nombres'] . ' ' . $empleado['apellidos'],
                    'valor' => $empleado['valor'],
                    'estado' => 'aprobado',
                    'numero_transaccion' => $this->generarNumeroTransaccion(),
                    'fecha_procesamiento' => now()->format('Y-m-d H:i:s')
                ];
                $empleadosExitosos++;
            } else {
                $empleadosProcesados[] = [
                    'cedula' => $empleado['cedula'],
                    'nombre_completo' => $empleado['nombres'] . ' ' . $empleado['apellidos'],
                    'valor' => $empleado['valor'],
                    'estado' => 'rechazado',
                    'codigo_error' => $this->generarCodigoError(),
                    'mensaje_error' => $this->obtenerMensajeError(),
                    'fecha_procesamiento' => now()->format('Y-m-d H:i:s')
                ];
                $empleadosFallidos++;
            }
        }

        \Log::info('API Banco - Dispersión de nómina', [
            'lote_id' => $loteId,
            'periodo' => $request->periodo,
            'total_empleados' => $totalEmpleados,
            'exitosos' => $empleadosExitosos,
            'fallidos' => $empleadosFallidos,
            'monto_total' => $montoTotal
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dispersión de nómina procesada',
            'data' => [
                'lote_id' => $loteId,
                'estado_lote' => $empleadosFallidos > 0 ? 'procesado_con_errores' : 'procesado_exitosamente',
                'fecha_procesamiento' => now()->format('Y-m-d H:i:s'),
                'resumen' => [
                    'total_empleados' => $totalEmpleados,
                    'exitosos' => $empleadosExitosos,
                    'fallidos' => $empleadosFallidos,
                    'monto_total' => $montoTotal,
                    'monto_procesado' => collect($empleadosProcesados)
                        ->where('estado', 'aprobado')
                        ->sum('valor')
                ],
                'detalle_empleados' => $empleadosProcesados,
                'cuenta_debito' => [
                    'numero' => $request->cuenta_debito,
                    'saldo_previo' => rand(50000000, 100000000),
                    'monto_debitado' => $montoTotal,
                    'saldo_actual' => rand(40000000, 90000000)
                ]
            ]
        ], 201);
    }

    /**
     * Consultar estado de un lote de nómina
     * GET /api/banco/nomina/lote/{lote_id}
     */
    public function consultarLote($loteId)
    {
        sleep(1);

        // Simular búsqueda del lote
        $estadosPosibles = [
            'procesando' => 10,
            'procesado' => 80,
            'error' => 5,
            'revertido' => 5
        ];

        $estado = $this->seleccionarEstadoAleatorio($estadosPosibles);

        \Log::info('API Banco - Consulta de lote', [
            'lote_id' => $loteId,
            'estado' => $estado
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'lote_id' => $loteId,
                'estado' => $estado,
                'fecha_creacion' => now()->subHours(rand(1, 48))->format('Y-m-d H:i:s'),
                'fecha_procesamiento' => now()->subHours(rand(0, 24))->format('Y-m-d H:i:s'),
                'total_transacciones' => rand(10, 100),
                'transacciones_exitosas' => rand(9, 95),
                'transacciones_fallidas' => rand(0, 5),
                'monto_total' => rand(10000000, 50000000),
                'archivo_respuesta_url' => "https://banco-api.com/archivos/{$loteId}.txt"
            ]
        ], 200);
    }

    /**
     * Consultar transacción individual
     * GET /api/banco/nomina/transaccion/{numero_transaccion}
     */
    public function consultarTransaccion($numeroTransaccion)
    {
        sleep(1);

        $estados = ['exitosa', 'pendiente', 'rechazada', 'reversada'];
        $estado = $estados[array_rand($estados)];

        return response()->json([
            'success' => true,
            'data' => [
                'numero_transaccion' => $numeroTransaccion,
                'estado' => $estado,
                'fecha_transaccion' => now()->subHours(rand(1, 72))->format('Y-m-d H:i:s'),
                'valor' => rand(1000000, 5000000),
                'cuenta_origen' => '****' . rand(1000, 9999),
                'cuenta_destino' => '****' . rand(1000, 9999),
                'banco_destino' => $this->obtenerBancoAleatorio(),
                'tipo_cuenta' => ['ahorros', 'corriente'][rand(0, 1)],
                'comprobante_url' => "https://banco-api.com/comprobantes/{$numeroTransaccion}.pdf",
                'observaciones' => $estado === 'rechazada' ? $this->obtenerMensajeError() : null
            ]
        ], 200);
    }

    /**
     * Validar cuenta bancaria antes de dispersión
     * POST /api/banco/validar-cuenta
     */
    public function validarCuenta(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_cuenta' => 'required|string',
            'tipo_cuenta' => 'required|in:ahorros,corriente',
            'banco' => 'required|string',
            'cedula_titular' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        sleep(1);

        // 90% de cuentas válidas
        $valida = rand(1, 100) <= 90;

        if ($valida) {
            return response()->json([
                'success' => true,
                'data' => [
                    'cuenta_valida' => true,
                    'numero_cuenta' => $request->numero_cuenta,
                    'tipo_cuenta' => $request->tipo_cuenta,
                    'banco' => $request->banco,
                    'estado_cuenta' => 'activa',
                    'titular' => $this->generarNombreTitular(),
                    'cedula_titular' => $request->cedula_titular,
                    'coincide_titular' => true
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Cuenta bancaria inválida',
                'data' => [
                    'cuenta_valida' => false,
                    'codigo_error' => $this->generarCodigoError(),
                    'mensaje_error' => $this->obtenerMensajeError()
                ]
            ], 422);
        }
    }

    /**
     * Obtener saldo disponible para dispersión
     * GET /api/banco/saldo
     */
    public function consultarSaldo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cuenta' => 'required|string',
            'empresa_nit' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        sleep(1);

        $saldo = rand(50000000, 200000000);

        return response()->json([
            'success' => true,
            'data' => [
                'cuenta' => $request->cuenta,
                'saldo_disponible' => $saldo,
                'saldo_bloqueado' => rand(0, 10000000),
                'limite_diario' => 500000000,
                'monto_usado_hoy' => rand(0, 100000000),
                'fecha_consulta' => now()->format('Y-m-d H:i:s')
            ]
        ], 200);
    }

    /**
     * Revertir una dispersión de nómina
     * POST /api/banco/nomina/revertir
     */
    public function revertirDispersion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lote_id' => 'required|string',
            'motivo' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        sleep(2);

        $exitoso = rand(1, 100) <= 90;

        if ($exitoso) {
            \Log::info('API Banco - Reversión exitosa', [
                'lote_id' => $request->lote_id,
                'motivo' => $request->motivo
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reversión procesada exitosamente',
                'data' => [
                    'lote_id' => $request->lote_id,
                    'estado' => 'revertido',
                    'fecha_reversion' => now()->format('Y-m-d H:i:s'),
                    'transacciones_revertidas' => rand(10, 100),
                    'monto_total_revertido' => rand(10000000, 50000000)
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo procesar la reversión',
                'codigo_error' => 'REV_ERROR_001',
                'detalle' => 'El lote ya fue procesado y no puede ser revertido'
            ], 422);
        }
    }

    /**
     * Webhook - Notificación de estado de transacción
     * POST /api/banco/webhook/transaccion
     */
    public function webhookTransaccion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lote_id' => 'required|string',
            'numero_transaccion' => 'required|string',
            'estado' => 'required|string',
            'valor' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        \Log::info('API Banco - Webhook transacción', $request->all());

        return response()->json([
            'success' => true,
            'message' => 'Notificación recibida',
            'timestamp' => now()->toISOString()
        ], 200);
    }

    // Métodos auxiliares
    private function generarLoteId(): string
    {
        return 'LOTE-' . now()->format('Ymd') . '-' . strtoupper(Str::random(8));
    }

    private function generarNumeroTransaccion(): string
    {
        return 'TRX-' . now()->format('YmdHis') . '-' . rand(1000, 9999);
    }

    private function generarCodigoError(): string
    {
        $codigos = ['E001', 'E002', 'E003', 'E004', 'E005'];
        return $codigos[array_rand($codigos)];
    }

    private function obtenerMensajeError(): string
    {
        $mensajes = [
            'Cuenta inactiva o bloqueada',
            'Datos incorrectos del beneficiario',
            'Saldo insuficiente',
            'Límite diario excedido',
            'Cuenta no válida para transacciones'
        ];
        return $mensajes[array_rand($mensajes)];
    }

    private function obtenerBancoAleatorio(): string
    {
        $bancos = ['Bancolombia', 'Banco de Bogotá', 'Davivienda', 'BBVA', 'Banco Popular', 'Colpatria'];
        return $bancos[array_rand($bancos)];
    }

    private function generarNombreTitular(): string
    {
        $nombres = ['Juan', 'María', 'Carlos', 'Ana', 'Pedro', 'Laura'];
        $apellidos = ['Pérez', 'González', 'Rodríguez', 'López', 'Martínez', 'García'];
        return $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)];
    }

    private function seleccionarEstadoAleatorio($estadosProbabilidades): string
    {
        $rand = rand(1, 100);
        $acumulado = 0;

        foreach ($estadosProbabilidades as $estado => $probabilidad) {
            $acumulado += $probabilidad;
            if ($rand <= $acumulado) {
                return $estado;
            }
        }

        return array_key_first($estadosProbabilidades);
    }
}