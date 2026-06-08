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
            ? $user->pollasAdministradas()->withCount('apostadores')->latest()->get()
            : $user->pollas()->with('administrador')->latest()->get();

        $pollasDisponibles = $user->esAdministrador()
            ? collect()
            : Polla::with('administrador')
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

        return view('pollas.create');
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

        $polla->apostadores()->syncWithoutDetaching([$request->user()->id]);

        return redirect()->route('dashboard')->with('status', 'Te uniste a la polla correctamente.');
    }
}
