<?php

namespace Database\Seeders;

use App\Models\Partido;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PartidosMundial2026Seeder extends Seeder
{
    public function run(): void
    {
        // Limpiamos los partidos anteriores (como los de 2022)
        Partido::truncate();

        $partidos = [
            // Grupo A
            ['Mexico', 'Sudafrica', '2026-06-11 10:00:00'],
            ['Corea del Sur', 'Republica Checa', '2026-06-11 14:00:00'],
            // Grupo B
            ['Canada', 'Bosnia y Herzegovina', '2026-06-12 10:00:00'],
            ['Qatar', 'Suiza', '2026-06-12 14:00:00'],
            // Grupo C
            ['Brasil', 'Marruecos', '2026-06-13 10:00:00'],
            ['Haiti', 'Escocia', '2026-06-13 14:00:00'],
            // Grupo D
            ['Estados Unidos', 'Paraguay', '2026-06-14 10:00:00'],
            ['Australia', 'Turquia', '2026-06-14 14:00:00'],
            // Grupo E
            ['Argentina', 'Egipto', '2026-06-15 10:00:00'],
            ['Dinamarca', 'Japon', '2026-06-15 14:00:00'],
            // Grupo F
            ['Inglaterra', 'Colombia', '2026-06-16 10:00:00'],
            ['Costa de Marfil', 'Croacia', '2026-06-16 14:00:00'],
            // Grupo G
            ['España', 'Nigeria', '2026-06-17 10:00:00'],
            ['Ecuador', 'Suecia', '2026-06-17 14:00:00'],
            // Grupo H
            ['Francia', 'Senegal', '2026-06-18 10:00:00'],
            ['Uruguay', 'Iran', '2026-06-18 14:00:00'],
        ];

        foreach ($partidos as $partido) {
            Partido::create([
                'equipo_local' => $partido[0],
                'equipo_visitante' => $partido[1],
                'fecha_inicio' => Carbon::parse($partido[2]),
                'goles_local' => null,
                'goles_visitante' => null,
                'estado' => 'pendiente',
            ]);
        }
    }
}
