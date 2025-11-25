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

    public function storeModulo(Request $request)
    {
        // Normalizar valores
        $data = $request->only([
            'title', 'description', 'duration',
            'genilay_recursos_link1', 'genilay_recursos_link2',
            'parent_id'
        ]);

        // Checkbox → si no viene, poner 0
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Crear o editar
        if ($request->filled('id')) {
            $modulo = Modulos::find($request->id);
            if (!$modulo) return back()->with('error', 'El módulo no existe');

            $modulo->update($data);
        } else {
            $modulo = Modulos::create($data);
        }

        /*
        |--------------------------------------------------------------------------
        | 1. USUARIOS VISIBLES (guardar relación)
        |--------------------------------------------------------------------------
        */
        if ($request->has('visible_users')) {
            $modulo->active_users = $request->visible_users; // JSON en BD
            $modulo->save();
        } else {
            // Si no se selecciona nada → guardar []
            $modulo->active_users = null;
            $modulo->save();
        }

        /*
        |--------------------------------------------------------------------------
        | 2. RECURSOS: eliminar, agregar
        |--------------------------------------------------------------------------
        */
        if ($request->filled('delete_recursos')) {
            $idsToDelete = $request->delete_recursos;
            foreach ($modulo->recursos()->whereIn('id', $idsToDelete)->get() as $recurso) {
                Storage::disk('public')->delete($recurso->file_path);
                $recurso->delete();
            }
        }

        if ($request->hasFile('recursos')) {
            foreach ($request->file('recursos') as $file) {
                $path = $file->store('recursos', 'public');
                $modulo->recursos()->create([
                    'file_path' => $path,
                    'file_type' => $file->extension(),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. PASOS (actualizar, crear, eliminar)
        |--------------------------------------------------------------------------
        */
        if ($request->has('steps')) {
            $stepIdsInRequest = [];

            foreach ($request->steps as $stepData) {

                if (!empty($stepData['id'])) {
                    $step = $modulo->steps()->find($stepData['id']);
                    if ($step) {

                        if (isset($stepData['file']) && $stepData['file']) {
                            if ($step->file && Storage::disk('public')->exists($step->file)) {
                                Storage::disk('public')->delete($step->file);
                            }
                            $stepData['file'] = $stepData['file']->store('steps', 'public');
                        } else {
                            $stepData['file'] = $step->file;
                        }

                        $step->update([
                            'text' => $stepData['text'] ?? '',
                            'icon' => $stepData['icon'] ?? null,
                            'type' => $stepData['type'] ?? null,
                            'file' => $stepData['file'],
                        ]);

                        $stepIdsInRequest[] = $step->id;
                    }
                } else {
                    $filePath = null;
                    if (isset($stepData['file']) && $stepData['file']) {
                        $filePath = $stepData['file']->store('steps', 'public');
                    }

                    $newStep = $modulo->steps()->create([
                        'text' => $stepData['text'] ?? '',
                        'icon' => $stepData['icon'] ?? null,
                        'type' => $stepData['type'] ?? null,
                        'file' => $filePath,
                    ]);

                    $stepIdsInRequest[] = $newStep->id;
                }
            }

            $modulo->steps()
                ->whereNotIn('id', $stepIdsInRequest)
                ->each(function ($step) {
                    if ($step->file && Storage::disk('public')->exists($step->file)) {
                        Storage::disk('public')->delete($step->file);
                    }
                    $step->delete();
                });
        }

        /*
        |--------------------------------------------------------------------------
        | 4. PREGUNTAS
        |--------------------------------------------------------------------------
        */
        if ($request->has('preguntas')) {
            $modulo->preguntas()->delete();
            foreach ($request->preguntas as $pregunta) {
                $modulo->preguntas()->create([
                    'pregunta'             => $pregunta['pregunta'],
                    'opciones'             => $pregunta['opciones'] ?? [],
                    'respuestas_correctas' => $pregunta['respuestas_correctas'] ?? [],
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 5. IMÁGENES
        |--------------------------------------------------------------------------
        */

        // 5.1 Eliminar imágenes
        if ($request->filled('delete_imagenes')) {
            $idsToDelete = (array) $request->delete_imagenes;
            foreach ($modulo->images()->whereIn('id', $idsToDelete)->get() as $img) {
                if ($img->image_path && Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
                $img->delete();
            }
        }

        // 5.2 Actualizar o crear imágenes
        if ($request->has('imagenes')) {
            foreach ($request->imagenes as $index => $imgData) {

                if (!empty($imgData['id'])) {
                    $imagen = $modulo->images()->find($imgData['id']);
                    if (!$imagen) continue;

                    $imagen->description = $imgData['description'] ?? $imagen->description;

                    $uploaded = $request->file("imagenes.$index.file");
                    if ($uploaded) {
                        if ($imagen->image_path && Storage::disk('public')->exists($imagen->image_path)) {
                            Storage::disk('public')->delete($imagen->image_path);
                        }
                        $imagen->image_path = $uploaded->store('modulos/imagenes', 'public');
                    }

                    $imagen->save();
                } 
                else {
                    $uploaded = $request->file("imagenes.$index.file");
                    if ($uploaded) {
                        $path = $uploaded->store('modulos/imagenes', 'public');
                        $modulo->images()->create([
                            'image_path' => $path,
                            'description' => $imgData['description'] ?? null,
                        ]);
                    }
                }
            }
        }

        $accion = $request->filled('id') ? 'actualizado' : 'creado';
        return redirect()->back()->with('success', "Módulo {$accion} exitosamente.");
    }


    public function exportUsuarios(Request $request)
    {
        $subred = $request->input('subred');
        return Excel::download(new UsuariosExport($subred), 'usuarios_'.$subred.'.xlsx');
    }




}
