<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use App\Models\Polla;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PollaController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $partidos = Partido::orderBy('fecha_inicio')->get();
        $partidosProximos = Partido::where('fecha_inicio', '>=', now())
            ->orderBy('fecha_inicio')
            ->get();
        $partidosImportados = Partido::orderByDesc('fecha_inicio')
            ->limit(12)
            ->get();

        $misPollas = $user->esAdministrador()
            ? $user->pollasAdministradas()->with(['apostadores', 'partido'])->withCount('apostadores')->latest()->get()
            : $user->pollas()->with(['administrador', 'apostadores', 'partido'])->latest()->get();

        $pollasDisponibles = $user->esAdministrador()
            ? collect()
            : Polla::with(['administrador', 'apostadores', 'partido'])
                ->where('estado', 'abierta')
                ->whereDoesntHave('apostadores', fn ($query) => $query->where('users.id', $user->id))
                ->latest()
                ->get();

        return view('dashboard', compact('partidos', 'partidosProximos', 'partidosImportados', 'misPollas', 'pollasDisponibles'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        if (! $request->user()->esAdministrador()) {
            return redirect()->route('dashboard')->with('status', 'Solo los administradores pueden crear pollas.');
        }

        $partidos = Partido::where('fecha_inicio', '>=', now())->orderBy('fecha_inicio')->get();

        return view('pollas.create', compact('partidos'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (! $request->user()->esAdministrador()) {
            return redirect()->route('dashboard')->with('status', 'Solo los administradores pueden crear pollas.');
        }

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'monto' => ['required', 'numeric', 'min:0'],
            'partido_id' => ['required', 'exists:partidos,id'],
        ]);

        $request->user()->pollasAdministradas()->create($data);

        return redirect()->route('dashboard')->with('status', 'Polla creada correctamente.');
    }

    public function join(Request $request, Polla $polla): RedirectResponse
    {
        if ($request->user()->esAdministrador()) {
            return redirect()->route('dashboard')->with('status', 'Los administradores gestionan pollas, no se unen como apostadores.');
        }

        if ($polla->estado !== 'abierta') {
            return redirect()->route('dashboard')->with('status', 'Esta polla ya no esta abierta.');
        }

        $request->validate([
            'marcador_local' => ['required', 'integer', 'min:0'],
            'marcador_visitante' => ['required', 'integer', 'min:0'],
        ]);

        $existeMarcador = $polla->apostadores()
            ->wherePivot('marcador_local', $request->marcador_local)
            ->wherePivot('marcador_visitante', $request->marcador_visitante)
            ->exists();

        if ($existeMarcador) {
            return back()->with('status', 'Error: Ese marcador ya fue elegido por otro apostador en esta polla. Intenta con uno distinto.');
        }

        $polla->apostadores()->syncWithoutDetaching([
            $request->user()->id => [
                'marcador_local' => $request->marcador_local,
                'marcador_visitante' => $request->marcador_visitante,
            ]
        ]);

        return redirect()->route('dashboard')->with('status', 'Te uniste a la polla correctamente con el marcador ' . $request->marcador_local . '-' . $request->marcador_visitante . '.');
    }

    public function destroy(Request $request, Polla $polla): RedirectResponse
    {
        if (! $request->user()->esAdministrador() || $polla->administrador_id !== $request->user()->id) {
            return redirect()->route('dashboard')->with('status', 'No tienes permiso para eliminar esta polla.');
        }

        $polla->delete();

        return redirect()->route('dashboard')->with('status', 'Polla eliminada correctamente.');
    }
}
