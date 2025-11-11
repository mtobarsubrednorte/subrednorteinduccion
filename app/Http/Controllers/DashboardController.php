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
        // ✅ Crear o editar
        if ($request->has('id') && !empty($request->id)) {
            $modulo = Modulos::find($request->id);
            if (!$modulo) return back()->with('error', 'El módulo no existe');

            $modulo->update($request->only([
                'title', 'description', 'duration',
                'genilay_recursos_link1', 'genilay_recursos_link2', 'parent_id'
            ]));
        } else {
            $modulo = Modulos::create($request->only([
                'title', 'description', 'duration',
                'genilay_recursos_link1', 'genilay_recursos_link2', 'parent_id'
            ]));
        }

        // ✅ ELIMINAR recursos marcados
        if ($request->filled('delete_recursos')) {
            $idsToDelete = $request->delete_recursos;
            foreach ($modulo->recursos()->whereIn('id', $idsToDelete)->get() as $recurso) {
                Storage::disk('public')->delete($recurso->file_path);
                $recurso->delete();
            }
        }

        // ✅ AGREGAR nuevos recursos
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

        // ✅ Pasos (puedes mejorarlo luego para edición individual)
        if ($request->has('steps')) {
            $stepIdsInRequest = [];

            foreach ($request->steps as $stepData) {
                // Si el paso tiene ID → actualizar
                if (!empty($stepData['id'])) {
                    $step = $modulo->steps()->find($stepData['id']);
                    if ($step) {
                        // Si hay un nuevo archivo, reemplazarlo
                        if (isset($stepData['file']) && $stepData['file']) {
                            // Borra el archivo anterior si existe
                            if ($step->file && Storage::disk('public')->exists($step->file)) {
                                Storage::disk('public')->delete($step->file);
                            }
                            $filePath = $stepData['file']->store('steps', 'public');
                            $stepData['file'] = $filePath;
                        } else {
                            $stepData['file'] = $step->file; // mantiene el archivo anterior
                        }

                        $step->update([
                            'text' => $stepData['text'] ?? '',
                            'icon' => $stepData['icon'] ?? null,
                            'type' => $stepData['type'] ?? null,
                            'file' => $stepData['file'],
                        ]);
                        $stepIdsInRequest[] = $step->id;
                    }
                }
                // Si no tiene ID → crear nuevo
                else {
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

            // ✅ Eliminar los pasos que no vinieron en la solicitud (fueron quitados)
            $modulo->steps()
                ->whereNotIn('id', $stepIdsInRequest)
                ->get()
                ->each(function ($step) {
                    if ($step->file && Storage::disk('public')->exists($step->file)) {
                        Storage::disk('public')->delete($step->file);
                    }
                    $step->delete();
                });
        }


        // ✅ Preguntas (reemplazo total)
        if ($request->has('preguntas')) {
            $modulo->preguntas()->delete();
            foreach ($request->preguntas as $pregunta) {
                $modulo->preguntas()->create([
                    'pregunta' => $pregunta['pregunta'],
                    'opciones' => $pregunta['opciones'] ?? [],
                    'respuestas_correctas' => $pregunta['respuestas_correctas'] ?? [],
                ]);
            }
        }

        // -------------------------
        // IMÁGENES: eliminar, actualizar, crear
        // -------------------------
        // 1) Eliminar imágenes marcadas por el usuario aunque no venga 'imagenes'
        if ($request->filled('delete_imagenes')) {
            $idsToDelete = (array) $request->input('delete_imagenes', []);
            foreach ($modulo->images()->whereIn('id', $idsToDelete)->get() as $img) {
                // eliminar archivo físico si existe
                if ($img->image_path && Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
                $img->delete();
            }
        }

        // 2) Procesar imágenes enviadas (actualizar existentes / crear nuevas / reemplazar archivo)
        if ($request->has('imagenes')) {
            // recorrer con índice para poder leer $request->file("imagenes.$index.file")
            foreach ($request->imagenes as $index => $imagenData) {
                // Si trae id -> es imagen existente: actualizar descripción y opcionalmente reemplazar archivo
                if (!empty($imagenData['id'])) {
                    $imagen = $modulo->images()->find($imagenData['id']);
                    if (!$imagen) continue;

                    // actualizar descripción si viene
                    $imagen->description = $imagenData['description'] ?? $imagen->description;

                    // verificar si en este índice llegó un archivo para reemplazar
                    $uploaded = $request->file("imagenes.$index.file");
                    if ($uploaded) {
                        // borrar archivo anterior si existe
                        if ($imagen->image_path && Storage::disk('public')->exists($imagen->image_path)) {
                            Storage::disk('public')->delete($imagen->image_path);
                        }
                        $path = $uploaded->store('modulos/imagenes', 'public');
                        $imagen->image_path = $path;
                    }

                    $imagen->save();
                }
                // Si no trae id pero trae archivo -> crear nueva imagen
                else {
                    $uploaded = $request->file("imagenes.$index.file");
                    if ($uploaded) {
                        $path = $uploaded->store('modulos/imagenes', 'public');
                        $modulo->images()->create([
                            'image_path' => $path,
                            'description' => $imagenData['description'] ?? null,
                        ]);
                    }
                    // Si no hay file y no hay id, ignorar (campo vacío del formulario)
                }
            }
        }


        $accion = $request->has('id') ? 'actualizado' : 'creado';
        return redirect()->back()->with('success', "Módulo {$accion} exitosamente.");
    }

    public function exportUsuarios(Request $request)
    {
        $subred = $request->input('subred');
        return Excel::download(new UsuariosExport($subred), 'usuarios_'.$subred.'.xlsx');
    }




}
