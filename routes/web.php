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
        
         // Afiliaciones de Seguridad Social
        Route::resource('afiliaciones', AfiliacionController::class)->parameters([
            'afiliaciones' => 'afiliacion'
        ]);
        Route::get('afiliaciones-dashboard', [AfiliacionController::class, 'dashboard'])->name('afiliaciones.dashboard');
        Route::post('afiliaciones/{afiliacion}/enviar', [AfiliacionController::class, 'enviar'])->name('afiliaciones.enviar');
        Route::post('afiliaciones/{afiliacion}/completar', [AfiliacionController::class, 'completar'])->name('afiliaciones.completar');
        Route::get('afiliaciones/{afiliacion}/certificado', [AfiliacionController::class, 'descargarCertificado'])->name('afiliaciones.certificado');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    
});

require __DIR__.'/auth.php';