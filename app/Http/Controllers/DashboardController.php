<?php

namespace App\Http\Controllers;

use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $usuarios = User::count();
        $usuariosActivos = User::where('is_active', 1)->count();
        $usuariosInactivos = User::where('is_active', 0)->count();

        return view('admin.dashboard', compact('usuarios', 'usuariosActivos', 'usuariosInactivos'));
    }
}
