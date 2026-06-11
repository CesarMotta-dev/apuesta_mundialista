<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApuestaController;
use App\Http\Controllers\PollaController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Middleware\CheckApproval;
use Illuminate\Support\Facades\Route;

// 1. Ruta de Inicio (La que acabamos de crear para que no salga el 404)
Route::get('/', function () {
    return view('welcome');
});

// 2. Rutas protegidas por autenticación
Route::middleware(['auth', 'verified'])->group(function () {

    // Espera de Aprobación
    Route::view('/aprobacion-pendiente', 'auth.espera-aprobacion')->name('aprobacion.pendiente');

    // Rutas protegidas por Aprobación
    Route::middleware([CheckApproval::class])->group(function () {
        // Dashboard
        Route::get('/dashboard', [PollaController::class, 'dashboard'])->name('dashboard');

    // Gestión de Pollas
    Route::get('/pollas/crear', [PollaController::class, 'create'])->name('pollas.create');
    Route::post('/pollas', [PollaController::class, 'store'])->name('pollas.store');
    Route::post('/pollas/{polla}/unirse', [PollaController::class, 'join'])->name('pollas.join');
    Route::delete('/pollas/{polla}', [PollaController::class, 'destroy'])->name('pollas.destroy');

    // Gestión de Apuestas
    Route::put('/apuestas/{apuesta}', [ApuestaController::class, 'update'])->name('apuestas.update');

    // API y Sincronización (Aquí está la clave para tu API)
    Route::post('/api/actualizar-partidos', [ApuestaController::class, 'actualizarPartidosDesdeAPI'])->name('partidos.actualizar');
    Route::get('/probar-api', [ApuestaController::class, 'importarPartidosMundial'])->name('partidos.probar');

    // Super Admin Rutas
    Route::get('/superadmin/pendientes', [SuperAdminController::class, 'pendientes'])->name('superadmin.pendientes');
    Route::post('/superadmin/aprobar/{user}', [SuperAdminController::class, 'aprobar'])->name('superadmin.aprobar');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    }); // fin de CheckApproval
});

require __DIR__.'/auth.php';
