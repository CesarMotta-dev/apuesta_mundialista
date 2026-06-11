<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function pendientes()
    {
        if (!auth()->user()->esSuperAdmin()) {
            return redirect()->route('dashboard')->with('status', 'No tienes permiso.');
        }

        $pendientes = User::where('rol', 'administrador')->where('aprobado', false)->get();

        return view('superadmin.pendientes', compact('pendientes'));
    }

    public function aprobar(User $user)
    {
        if (!auth()->user()->esSuperAdmin()) {
            return redirect()->route('dashboard')->with('status', 'No tienes permiso.');
        }

        $user->update(['aprobado' => true]);

        return back()->with('status', "El administrador {$user->name} ha sido aprobado exitosamente.");
    }
}
