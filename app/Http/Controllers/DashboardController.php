<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $usuarios = User::count();
        $usuariosActivos = User::where('is_active', 1)->count();
        $usuariosInactivos = User::where('is_active', 0)->count();

        // Traer la lista de usuarios
        $listaUsuarios = User::with('profile:id,name')
            ->select('id', 'name', 'email', 'is_active', 'profile_id')
            ->where('subred', Auth::user()->subred)
            ->paginate(10);


        return view('admin.dashboard', compact('usuarios', 'usuariosActivos', 'usuariosInactivos', 'listaUsuarios'));
    }

    public function toggleEstado($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->is_active = !$usuario->is_active; // invierte el estado
        $usuario->save();

        return redirect()->back()->with('success', 'Estado del usuario actualizado correctamente.');
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('role', 'LIKE', "%{$search}%");
            });
        }

        $listaUsuarios = $query->paginate(10)->withQueryString();

        return view('admin.dashboard', compact('listaUsuarios'));
    }




}
