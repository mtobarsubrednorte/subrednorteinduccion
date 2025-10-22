<?php

namespace App\Http\Controllers;

use App\Models\Modulos;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


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

        // ✅ Imágenes: conservar, borrar las eliminadas y agregar nuevas
        if ($request->has('imagenes')) {
            $imagenesIdsExistentes = $modulo->images->pluck('id')->toArray();
            $imagenesIdsEnRequest = [];

            foreach ($request->imagenes as $imagenData) {
                // Si la imagen ya existe (tiene ID), actualizamos la descripción
                if (!empty($imagenData['id'])) {
                    $imagenesIdsEnRequest[] = $imagenData['id'];
                    $imagen = $modulo->images()->find($imagenData['id']);
                    if ($imagen) {
                        $imagen->update([
                            'description' => $imagenData['description'] ?? $imagen->description,
                        ]);
                    }
                }
                // Si es una nueva imagen (tiene archivo nuevo)
                elseif (isset($imagenData['file']) && $imagenData['file']) {
                    $path = $imagenData['file']->store('modulos/imagenes', 'public');
                    $modulo->images()->create([
                        'image_path' => $path,
                        'description' => $imagenData['description'] ?? null,
                    ]);
                }
            }

            // 🔥 Borrar imágenes que ya no están en el request
            $imagenesAEliminar = array_diff($imagenesIdsExistentes, $imagenesIdsEnRequest);
            foreach ($modulo->images()->whereIn('id', $imagenesAEliminar)->get() as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        $accion = $request->has('id') ? 'actualizado' : 'creado';
        return redirect()->back()->with('success', "Módulo {$accion} exitosamente.");
    }




}
