<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EntidadAfiliacionApiController;
use App\Http\Controllers\Api\PagoNominaApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Middleware de autenticación básica con token
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// API #1: Integración con Entidades de Seguridad Social
Route::prefix('entidades')->group(function () {
    // Enviar solicitud de afiliación
    Route::post('/afiliaciones', [EntidadAfiliacionApiController::class, 'enviarSolicitud']);
    
    // Consultar estado de afiliación
    Route::get('/afiliaciones/{numero_radicado}', [EntidadAfiliacionApiController::class, 'consultarEstado']);
    
    // Aprobar afiliación
    Route::post('/afiliaciones/{numero_radicado}/aprobar', [EntidadAfiliacionApiController::class, 'aprobarAfiliacion']);
    
    // Webhook para notificaciones
    Route::post('/webhook/estado', [EntidadAfiliacionApiController::class, 'webhookEstado']);
});

// API #2: Pagos y Nómina Electrónica
Route::prefix('banco')->group(function () {
    // Dispersión de nómina
    Route::post('/nomina/dispersar', [PagoNominaApiController::class, 'dispersarNomina']);
    
    // Consultar lote de nómina
    Route::get('/nomina/lote/{lote_id}', [PagoNominaApiController::class, 'consultarLote']);
    
    // Consultar transacción individual
    Route::get('/nomina/transaccion/{numero_transaccion}', [PagoNominaApiController::class, 'consultarTransaccion']);
    
    // Validar cuenta bancaria
    Route::post('/validar-cuenta', [PagoNominaApiController::class, 'validarCuenta']);
    
    // Consultar saldo
    Route::get('/saldo', [PagoNominaApiController::class, 'consultarSaldo']);
    
    // Revertir dispersión
    Route::post('/nomina/revertir', [PagoNominaApiController::class, 'revertirDispersion']);
    
    // Webhook para notificaciones
    Route::post('/webhook/transaccion', [PagoNominaApiController::class, 'webhookTransaccion']);
});

// Ruta de prueba
Route::get('/ping', function () {
    return response()->json([
        'message' => 'API GESTAL funcionando correctamente',
        'timestamp' => now()->toISOString(),
        'version' => '1.0.0'
    ]);
});