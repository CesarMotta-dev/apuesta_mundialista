<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApuestaController;
use App\Http\Controllers\PollaController;
use Illuminate\Support\Facades\Route;

// 1. Ruta de Inicio (La que acabamos de crear para que no salga el 404)
Route::get('/', function () {
    return view('welcome');
});

// 2. Rutas protegidas por autenticación
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [PollaController::class, 'dashboard'])->name('dashboard');

    // Gestión de Pollas
    Route::get('/pollas/crear', [PollaController::class, 'create'])->name('pollas.create');
    Route::post('/pollas', [PollaController::class, 'store'])->name('pollas.store');
    Route::post('/pollas/{polla}/unirse', [PollaController::class, 'join'])->name('pollas.join');

    // Gestión de Apuestas
    Route::put('/apuestas/{apuesta}', [ApuestaController::class, 'update'])->name('apuestas.update');

    // API y Sincronización (Aquí está la clave para tu API)
    Route::post('/api/actualizar-partidos', [ApuestaController::class, 'actualizarPartidosDesdeAPI'])->name('partidos.actualizar');
    Route::get('/probar-api', [ApuestaController::class, 'importarPartidosMundial'])->name('partidos.probar');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
