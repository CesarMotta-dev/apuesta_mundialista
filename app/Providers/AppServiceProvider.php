<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 1. AGREGAR ESTA LÍNEA AQUÍ ARRIBA

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        URL::forceScheme('https'); // 2. AGREGAR ESTA LÍNEA AQUÍ ADENTRO
    }
}
