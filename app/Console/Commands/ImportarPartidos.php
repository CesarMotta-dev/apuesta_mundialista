<?php

namespace App\Console\Commands;

use App\Services\FootballApiService;
use Illuminate\Console\Command;

class ImportarPartidos extends Command
{
    protected $signature = 'app:importar-partidos';

    protected $description = 'Importa partidos desde API-Football';

    public function handle(FootballApiService $api): int
    {
        $resultado = $api->obtenerPartidosMundial();

        if (! $resultado['ok']) {
            $this->error($resultado['message']);

            return self::FAILURE;
        }

        $this->info($resultado['message'] . ' Total importados: ' . $resultado['total'] . '.');

        return self::SUCCESS;
    }
}
