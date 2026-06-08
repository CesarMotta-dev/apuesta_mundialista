<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partido;

class ApuestaController extends Controller
{

// ... dentro de la clase ApuestaController

public function actualizarPartidosDesdeAPI(Request $request)
{
    // Recibimos la lista de partidos desde n8n
    $partidos = $request->all();

    foreach ($partidos as $datosPartido) {
        // Buscamos si el partido ya existe por los equipos, o lo creamos si es nuevo
        Partido::updateOrCreate(
            [
                'equipo_local' => $datosPartido['home_team'],
                'equipo_visitante' => $datosPartido['away_team'],
            ],
            [
                'fecha_inicio' => $datosPartido['start_time'],
                'goles_local' => $datosPartido['home_score'] ?? null,
                'goles_visitante' => $datosPartido['away_score'] ?? null,
                'estado' => $datosPartido['status'] ?? 'pendiente',
            ]
        );
    }

    return response()->json(['status' => 'success', 'message' => 'Partidos actualizados']);
}       //
}
