<?php

namespace Database\Seeders;

use App\Models\Partido;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartidosMundial2026Seeder extends Seeder
{
    public function run(): void
    {
        // Limpiamos los partidos anteriores (esto borra también las pollas y apuestas para evitar errores de consistencia)
        DB::table('polla_user')->delete();
        DB::table('apuestas')->delete();
        DB::table('pollas')->delete();
        Partido::query()->delete();

        // 1. Cargar equipos desde teams.csv
        $equipos = [];
        $teamsPath = database_path('data/teams.csv');
        if (file_exists($teamsPath)) {
            $file = fopen($teamsPath, 'r');
            $header = fgetcsv($file); // Saltar cabecera
            while (($row = fgetcsv($file)) !== false) {
                // $row[0] = id, $row[1] = team_name
                $equipos[$row[0]] = $row[1];
            }
            fclose($file);
        } else {
            $this->command->error("No se encontró el archivo teams.csv en database/data/");
            return;
        }

        // 2. Cargar partidos desde matches.csv
        $matchesPath = database_path('data/matches.csv');
        if (file_exists($matchesPath)) {
            $file = fopen($matchesPath, 'r');
            $header = fgetcsv($file); // Saltar cabecera
            
            while (($row = fgetcsv($file)) !== false) {
                // id(0), match_number(1), home_team_id(2), away_team_id(3), city_id(4), stage_id(5), kickoff_at(6), match_label(7)
                
                $homeTeamId = $row[2];
                $awayTeamId = $row[3];
                $kickoffAt = $row[6]; // e.g. "2026-06-11 15:00:00-06"
                $matchLabel = $row[7]; // e.g. "Group A" or "1C vs 2F"

                // Determinar el nombre del equipo local
                if (!empty($homeTeamId) && isset($equipos[$homeTeamId])) {
                    $equipoLocal = $equipos[$homeTeamId];
                } else {
                    // Si está vacío, intentamos deducir de la etiqueta del partido o dejamos "Por definir"
                    if (str_contains($matchLabel, ' vs ')) {
                        $partes = explode(' vs ', $matchLabel);
                        $equipoLocal = trim($partes[0]);
                    } else {
                        $equipoLocal = 'Por definir';
                    }
                }

                // Determinar el nombre del equipo visitante
                if (!empty($awayTeamId) && isset($equipos[$awayTeamId])) {
                    $equipoVisitante = $equipos[$awayTeamId];
                } else {
                    if (str_contains($matchLabel, ' vs ')) {
                        $partes = explode(' vs ', $matchLabel);
                        $equipoVisitante = trim($partes[1] ?? 'Por definir');
                    } else {
                        $equipoVisitante = 'Por definir';
                    }
                }

                // Parsear la fecha ajustando el huso horario original a la hora local para la DB (Colombia/America Latina usualmente)
                $fechaParseada = Carbon::parse($kickoffAt)->setTimezone('America/Bogota');

                Partido::create([
                    'equipo_local' => $equipoLocal,
                    'equipo_visitante' => $equipoVisitante,
                    'fecha_inicio' => $fechaParseada,
                    'goles_local' => null,
                    'goles_visitante' => null,
                    'estado' => 'pendiente',
                ]);
            }
            fclose($file);
            $this->command->info("Se importaron 104 partidos exitosamente desde los archivos CSV oficiales.");
        } else {
            $this->command->error("No se encontró el archivo matches.csv en database/data/");
        }
    }
}
