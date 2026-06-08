<?php

namespace App\Http\Controllers;

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
}
