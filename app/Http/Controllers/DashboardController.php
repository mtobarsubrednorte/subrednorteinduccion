<?php

namespace App\Http\Controllers;

use App\Models\Modulos;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Activity;

use App\Exports\UsuariosExport;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    /**
     * Datos comunes del dashboard para no repetir código.
     */
    private function getDashboardData()
    {
        return [
            'listaUser' => User::orderBy('name')->get(),
            'usuarios' => User::count(),
            'usuariosActivos' => User::where('is_active', 1)->count(),
            'usuariosInactivos' => User::where('is_active', 0)->count(),
            'modulos' => Modulos::with(['recursos', 'preguntas', 'steps', 'images'])->paginate(6),
            'activities' => Activity::latest()->take(10)->get(),

            'perfiles' => Profile::get(),
        ];
    }

    public function dashboard()
    {
        $data = $this->getDashboardData();

        $listaUsuarios = User::with('profile:id,name')
            ->select('id', 'name', 'email', 'is_active', 'profile_id')
            ->where('subred', Auth::user()->subred)
            ->paginate(10);

        return view('admin.dashboard', array_merge($data, compact('listaUsuarios')));
    }

    public function toggleEstado($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->is_active = !$usuario->is_active;
        $usuario->save();

        return redirect()->back()->with('success', 'Estado del usuario actualizado correctamente.');
    }

    public function searchUsuarios(Request $request)
    {
        // Filtramos por subred desde el inicio
        $query = User::where('subred', Auth::user()->subred);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('role', 'LIKE', "%{$search}%");
            });
        }

        $listaUsuarios = $query
            ->with('profile:id,name')
            ->select('id', 'name', 'email', 'is_active', 'profile_id')
            ->paginate(10)
            ->withQueryString();

        $data = $this->getDashboardData();

        return view('admin.dashboard', array_merge($data, compact('listaUsuarios')));
    }




    public function exportUsuarios(Request $request)
    {
        $subred = $request->input('subred');
        return Excel::download(new UsuariosExport($subred), 'usuarios_' . $subred . '.xlsx');
    }
}
