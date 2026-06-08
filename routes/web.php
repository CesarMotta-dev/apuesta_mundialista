<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApuestaController;
use App\Http\Controllers\PollaController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('auth.login');
});

Route::get('/dashboard', [PollaController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/pollas/crear', [PollaController::class, 'create'])->name('pollas.create');
    Route::post('/pollas', [PollaController::class, 'store'])->name('pollas.store');
    Route::post('/pollas/{polla}/unirse', [PollaController::class, 'join'])->name('pollas.join');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/api/actualizar-partidos', [ApuestaController::class, 'actualizarPartidosDesdeAPI'])->name('partidos.actualizar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/probar-api', [ApuestaController::class, 'importarPartidosMundial']);
});

require __DIR__.'/auth.php';
