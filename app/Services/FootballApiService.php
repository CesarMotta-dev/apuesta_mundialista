<?php

namespace App\Services;

use App\Models\Partido;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class FootballApiService
{
    public function obtenerPartidosMundial(): array
    {
        try {
            $response = $this->consultarFixtures([
                'league' => config('services.api_football.league'),
                'season' => config('services.api_football.season'),
            ]);
        } catch (ConnectionException $exception) {
            return [
                'ok' => false,
                'total' => 0,
                'message' => 'No se pudo conectar con la API de futbol.',
                'error' => $exception->getMessage(),
            ];
        }

        if (! $response->successful()) {
            return [
                'ok' => false,
                'total' => 0,
                'message' => 'No se pudo conectar con la API de futbol.',
                'error' => $response->json('message') ?? $response->body(),
            ];
        }

        $apiErrors = $response->json('errors') ?? [];

        if (! empty($apiErrors)) {
            return [
                'ok' => false,
                'total' => 0,
                'message' => 'La API respondio con errores: ' . $this->formatearErrores($apiErrors),
                'error' => $apiErrors,
            ];
        }

        $fixtures = $response->json('response') ?? [];
        $origen = 'Mundial';

        if (count($fixtures) === 0) {
            $response = $this->consultarFixtures([
                'next' => config('services.api_football.next', 30),
            ]);

            if (! $response->successful()) {
                return [
                    'ok' => false,
                    'total' => 0,
                    'message' => 'No se encontraron partidos del Mundial y fallo la consulta de eventos proximos.',
                    'error' => $response->json('message') ?? $response->body(),
                ];
            }

            $apiErrors = $response->json('errors') ?? [];

            if (! empty($apiErrors)) {
                return [
                    'ok' => false,
                    'total' => 0,
                    'message' => 'La API respondio con errores: ' . $this->formatearErrores($apiErrors),
                    'error' => $apiErrors,
                ];
            }

            $fixtures = $response->json('response') ?? [];
            $origen = 'eventos proximos';
        }

        if (count($fixtures) === 0) {
            return [
                'ok' => true,
                'total' => 0,
                'message' => 'La API respondio bien, pero no devolvio partidos para Mundial ni eventos proximos.',
            ];
        }

        foreach ($fixtures as $fixture) {
            $fechaPartido = Carbon::parse($fixture['fixture']['date'])->setTimezone('America/Bogota');
            $estadoApi = $fixture['fixture']['status']['short'];

            $estadoLocal = match (true) {
                in_array($estadoApi, ['1H', '2H', 'HT', 'ET', 'P'], true) => 'jugandose',
                in_array($estadoApi, ['FT', 'AET', 'PEN'], true) => 'finalizado',
                default => 'pendiente',
            };

            Partido::updateOrCreate(
                [
                    'equipo_local' => $fixture['teams']['home']['name'],
                    'equipo_visitante' => $fixture['teams']['away']['name'],
                    'fecha_inicio' => $fechaPartido,
                ],
                [
                    'goles_local' => $fixture['goals']['home'],
                    'goles_visitante' => $fixture['goals']['away'],
                    'estado' => $estadoLocal,
                ]
            );
        }

        return [
            'ok' => true,
            'total' => count($fixtures),
            'message' => 'Partidos actualizados correctamente desde ' . $origen . '.',
        ];
    }

    private function consultarFixtures(array $query)
    {
        return Http::withHeaders([
            'x-apisports-key' => config('services.api_football.key'),
        ])->get(rtrim(config('services.api_football.url'), '/') . '/fixtures', $query);
    }

    private function formatearErrores(array $errors): string
    {
        return collect($errors)->flatten()->implode(' ');
    }
}
