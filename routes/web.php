<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\VacanteController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\ProcesoSeleccionController;
use App\Http\Controllers\PortalPublicoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AfiliacionController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\CapacitacionController;
use App\Http\Controllers\ReporteController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas públicas del portal de empleos (FUERA del middleware auth)
Route::prefix('empleos')->name('portal.')->group(function () {
    Route::get('/', [PortalPublicoController::class, 'index'])->name('index');
    Route::get('/vacante/{vacante}', [PortalPublicoController::class, 'show'])->name('vacante');
    Route::get('/aplicar/{vacante}', [PortalPublicoController::class, 'aplicar'])->name('aplicar');
    Route::post('/aplicar/{vacante}', [PortalPublicoController::class, 'store'])->name('store');
    Route::get('/confirmacion', [PortalPublicoController::class, 'confirmacion'])->name('confirmacion');
    Route::get('/consultar-estado', [PortalPublicoController::class, 'consultarEstado'])->name('consultar');
    Route::post('/consultar-estado', [PortalPublicoController::class, 'consultarEstado'])->name('consultar.post');
    Route::get('/buscar', [PortalPublicoController::class, 'buscar'])->name('buscar');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas protegidas para admin y analista_rh
    Route::middleware('role:admin,analista_rh')->group(function () {
        // Empleados
        Route::resource('empleados', EmpleadoController::class);
        
        // Vacantes
        Route::resource('vacantes', VacanteController::class);
        Route::post('vacantes/{vacante}/publicar', [VacanteController::class, 'publicar'])->name('vacantes.publicar');
        Route::post('vacantes/{vacante}/cerrar', [VacanteController::class, 'cerrar'])->name('vacantes.cerrar');
        
        // Candidatos
        Route::resource('candidatos', CandidatoController::class);
        Route::post('candidatos/{candidato}/cambiar-estado', [CandidatoController::class, 'cambiarEstado'])->name('candidatos.cambiar-estado');
        
        // Proceso de Selección
        Route::resource('proceso-seleccion', ProcesoSeleccionController::class);
        Route::post('proceso-seleccion/{procesoSeleccion}/calificar', [ProcesoSeleccionController::class, 'calificar'])->name('proceso-seleccion.calificar');
        
        // Nóminas
        Route::resource('nomina', NominaController::class);
        Route::post('nomina/{nomina}/calcular', [NominaController::class, 'calcular'])->name('nomina.calcular');
        Route::post('nomina/{nomina}/aprobar', [NominaController::class, 'aprobar'])->name('nomina.aprobar');
        Route::post('nomina/{nomina}/pagar', [NominaController::class, 'pagar'])->name('nomina.pagar');
        Route::post('nomina/{nomina}/anular', [NominaController::class, 'anular'])->name('nomina.anular');
        Route::get('nomina/{nomina}/desprendible', [NominaController::class, 'desprendible'])->name('nomina.desprendible');
        
        // Afiliaciones de Seguridad Social
        Route::resource('afiliaciones', AfiliacionController::class)->parameters([
            'afiliaciones' => 'afiliacion'
        ]);
        Route::get('afiliaciones-dashboard', [AfiliacionController::class, 'dashboard'])->name('afiliaciones.dashboard');
        Route::post('afiliaciones/{afiliacion}/enviar', [AfiliacionController::class, 'enviar'])->name('afiliaciones.enviar');
        Route::post('afiliaciones/{afiliacion}/completar', [AfiliacionController::class, 'completar'])->name('afiliaciones.completar');
        Route::get('afiliaciones/{afiliacion}/certificado', [AfiliacionController::class, 'descargarCertificado'])->name('afiliaciones.certificado');

        // Capacitaciones
        Route::resource('capacitaciones', CapacitacionController::class);
        Route::post('capacitaciones/{capacitacion}/inscribir', [CapacitacionController::class, 'inscribirEmpleado'])->name('capacitaciones.inscribir');
        Route::post('capacitaciones/{capacitacion}/cancelar', [CapacitacionController::class, 'cancelar'])->name('capacitaciones.cancelar');
        Route::post('capacitaciones/{capacitacion}/iniciar', [CapacitacionController::class, 'iniciar'])->name('capacitaciones.iniciar');
        Route::post('capacitaciones/{capacitacion}/completar', [CapacitacionController::class, 'completar'])->name('capacitaciones.completar');
        Route::post('capacitaciones/{capacitacion}/recordatorios', [CapacitacionController::class, 'enviarRecordatorios'])->name('capacitaciones.recordatorios');

        // Reportes
        Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('reportes/empleados', [ReporteController::class, 'empleados'])->name('reportes.empleados');
        Route::get('reportes/nomina', [ReporteController::class, 'nomina'])->name('reportes.nomina');
        Route::get('reportes/capacitaciones', [ReporteController::class, 'capacitaciones'])->name('reportes.capacitaciones');
        Route::get('reportes/seleccion', [ReporteController::class, 'seleccion'])->name('reportes.seleccion');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    
});


// Documentación de APIs
Route::get('/api/documentacion', function () {
    return view('api.documentacion');
})->name('api.documentacion');

require __DIR__.'/auth.php';