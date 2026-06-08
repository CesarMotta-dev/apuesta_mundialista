<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApuestaController;
use App\Models\Partido;

Route::get('/dashboard', function () {
    // Buscamos todos los partidos en la base de datos
    $partidos = Partido::all();

    // Se los pasamos a la vista 'dashboard'
    return view('dashboard', compact('partidos'));

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/api/actualizar-partidos', [ApuestaController::class, 'actualizarPartidosDesdeAPI']);
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
