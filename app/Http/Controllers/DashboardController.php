<?php

namespace App\Http\Controllers;

use App\Models\Modulos;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Datos comunes del dashboard para no repetir código.
     */
    private function getDashboardData()
    {
        return [
            'usuarios' => User::count(),
            'usuariosActivos' => User::where('is_active', 1)->count(),
            'usuariosInactivos' => User::where('is_active', 0)->count(),
            'modulos' => Modulos::paginate(6),
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

    public function storeModulo(Request $request)
    {

        Log::info('storeModulo iniciado', ['request' => $request->all()]);




        $modulo = Modulos::create($request->only(['title', 'description', 'duration', 'genilay_recursos_link1', 'genilay_recursos_link2', 'parent_id']));
        Log::info('Módulo creado', ['modulo_id' => $modulo->id]);
        // Guardar recursos
        if ($request->hasFile('recursos')) {
            foreach ($request->file('recursos') as $file) {
                $path = $file->store('recursos');
                $modulo->recursos()->create([
                    'file_path' => $path,
                    'file_type' => $file->extension(),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        if ($request->has('steps')) {
            foreach ($request->steps as $step) {
                // Saltar steps vacíos (cuando el usuario no llenó nada)
                if (empty($step['text']) && empty($step['icon']) && empty($step['file'])) {
                    continue;
                }

                $filePath = null;
                if (isset($step['file']) && $step['file']) {
                    $filePath = $step['file']->store('steps', 'public');
                }

                $modulo->steps()->create([
                    'text' => $step['text'] ?? '',
                    'icon' => $step['icon'] ?? null,
                    'type' => $step['type'] ?? null,
                    'file' => $filePath,
                ]);
            }
        }


        // Guardar preguntas
        if ($request->has('preguntas')) {
            foreach ($request->preguntas as $pregunta) {
                $modulo->preguntas()->create([
                    'pregunta' => $pregunta['pregunta'],
                    'opciones' => $pregunta['opciones'],
                    'respuestas_correctas' => $pregunta['respuestas_correctas'] ?? [],
                ]);
            }
        }

        if ($request->has('imagenes')) {
            foreach ($request->imagenes as $imagenData) {
                if (isset($imagenData['file'])) {
                    $path = $imagenData['file']->store('modulos/imagenes', 'public');
                    $modulo->images()->create([
                        'image_path' => $path,
                        'description' => $imagenData['description'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Curso creado exitosamente');
    }



}
