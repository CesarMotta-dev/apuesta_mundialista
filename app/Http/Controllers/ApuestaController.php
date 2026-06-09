<?php

namespace App\Http\Controllers;

use App\Models\Polla;
use App\Services\FootballApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApuestaController extends Controller
{
    public function actualizarPartidosDesdeAPI(Request $request, FootballApiService $api): RedirectResponse
    {
        $resultado = $api->obtenerPartidosMundial();

        if (! $resultado['ok']) {
            return back()->with('status', $resultado['message']);
        }

        return back()->with('status', $resultado['message'] . ' Total importados: ' . $resultado['total'] . '.');
    }

    public function importarPartidosMundial(FootballApiService $api)
    {
        $resultado = $api->obtenerPartidosMundial();

        return response()->json($resultado, $resultado['ok'] ? 200 : 500);
    }
 // En app/Http/Controllers/ApuestaController.php
public function join(Request $request, Polla $polla): RedirectResponse
{
    if ($request->user()->esAdministrador()) {
        return redirect()->route('dashboard')->with('status', 'Los administradores gestionan pollas, no se unen como apostadores.');
    }

    if ($polla->estado !== 'abierta') {
        return redirect()->route('dashboard')->with('status', 'Esta polla ya no esta abierta.');
    }

    // 1. Unir al usuario a la polla
    $polla->apostadores()->syncWithoutDetaching([$request->user()->id]);

    // 2. Crear las apuestas vacías para todos los partidos asociados a esta polla
    foreach ($polla->partidos as $partido) {
        \App\Models\Apuesta::firstOrCreate([
            'user_id'    => $request->user()->id,
            'partido_id' => $partido->id,
            'polla_id'   => $polla->id,
        ], [
            'marcador_local' => null, // O 0, según prefieras
            'marcador_visitante' => null,
        ]);
    }

    return redirect()->route('dashboard')->with('status', 'Te uniste a la polla y tus boletas de apuesta fueron generadas.');
}
}
