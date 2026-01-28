<?php

namespace App\Http\Controllers;

use App\Models\Modulos;
use Illuminate\Http\Request;
use App\Models\Step;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Certificate;
use App\Models\User;
use App\Models\Profile;


class Modules extends Controller
{
    public function showModulos()
    {
        $user = Auth::user();
        $userId = $user->id;

        $certificates = Certificate::where('user_id', $userId)->get();

        $modulos = Modulos::with(['submodulos', 'recursos', 'preguntas', 'steps', 'images'])
            ->whereNull('parent_id')
            ->where(function ($query) use ($userId) {

                // Mostrar módulos activos visibles para todos
                $query->where(function ($q) {
                    $q->where('active', true)
                        ->whereNull('active_users');
                });

                // Mostrar módulos activos SOLO para ciertos usuarios
                $query->orWhere(function ($q) use ($userId) {
                    $q->where('active', true)
                        ->whereRaw("JSON_CONTAINS(COALESCE(active_users, '[]'), '\"$userId\"')");
                });

                // Mostrar módulos INACTIVOS solo si el usuario está en la lista
                $query->orWhere(function ($q) use ($userId) {
                    $q->where('active', false)
                        ->whereRaw("JSON_CONTAINS(COALESCE(active_users, '[]'), '\"$userId\"')");
                });
            })
            ->get();

        Log::info('Módulos obtenidos para el usuario ' . $userId . ': ' . $modulos->count());

        return view('modules.module1', [
            'modulos' => $modulos,
            'certificates' => $certificates,
        ]);
    }




    public function responder(Request $request, Modulos $modulo)
    {
        $request->validate([
            'respuestas' => 'sometimes|array',
            'respuestas.*' => 'nullable|integer'
        ]);

        $user = Auth::user();
        $respuestasUsuario = $request->input('respuestas', []);
        $resultado = [];
        $correctas = 0;

        // Verificar que hay preguntas
        if ($modulo->preguntas->isEmpty()) {
            return redirect()->back()->with('error', 'El módulo no tiene preguntas');
        }

        foreach ($modulo->preguntas as $pregunta) {
            $respuestaUsuario = $respuestasUsuario[$pregunta->id] ?? null;

            // Validar que la opción seleccionada existe
            if ($respuestaUsuario !== null && !isset($pregunta->opciones[$respuestaUsuario])) {
                $respuestaUsuario = null;
            }

            $esCorrecta = in_array((int) $respuestaUsuario, $pregunta->respuestas_correctas);

            if ($esCorrecta) {
                $correctas++;
            }

            $resultado[] = [
                'pregunta' => $pregunta->pregunta,
                'respuesta_usuario' => $respuestaUsuario !== null
                    ? $pregunta->opciones[$respuestaUsuario]
                    : 'No respondió',
                'correcta' => $esCorrecta,
            ];
        }

        // ✅ Calificación
        $total = max(1, $modulo->preguntas->count());
        $calificacion = round(($correctas / $total) * 10);
        $aprobado = $calificacion >= 8;

        // Guardar resultado - CORREGIDO: user->id en lugar de user->id()
        DB::table('modulo_user')->updateOrInsert(
            ['user_id' => $user->id, 'modulo_id' => $modulo->id],
            [
                'calificacion' => $calificacion,
                'aprobado' => $aprobado,
                'updated_at' => now(),
                'created_at' => DB::raw('IFNULL(created_at, NOW())')
            ]
        );

        return redirect()->back()->with([
            'success' => "Terminaste el módulo {$modulo->title} con nota {$calificacion}/10. " .
                ($aprobado ? "¡Aprobaste! 🎉" : "No aprobaste 😢"),
            'resultado' => $resultado
        ]);
    }

    public function markComplete(Request $request)
    {
        $request->validate([
            'step_id' => 'required|exists:steps,id'
        ]);

        $user = Auth::user();
        $stepId = $request->input('step_id');
        $step = Step::findOrFail($stepId);

        // Asegúrate de que esta relación exista en el modelo User
        $user->completedSteps()->syncWithoutDetaching([
            $step->id => ['completed_at' => now()]
        ]);

        return response()->json(['success' => true]);
    }

    public function create()
    {
        $listaUsuarios = Profile::get();
        return view('admin.modulos.form', compact('listaUsuarios'));
    }

    public function edit($id)
    {
        $modulo = Modulos::with(['steps', 'images', 'recursos'])->findOrFail($id);
        $listaUsuarios = Profile::get();
        return view('admin.modulos.form', compact('modulo', 'listaUsuarios'));
    }

    public function storeModulo(Request $request)
    {
        // Normalizar valores
        $data = $request->only([
            'title',
            'description',
            'duration',
            'genilay_recursos_link1',
            'genilay_recursos_link2',
            'parent_id'
        ]);

        // Checkbox → si no viene, poner 0
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Crear o editar
        if ($request->filled('id')) {
            $modulo = Modulos::find($request->id);
            if (!$modulo)
                return back()->with('error', 'El módulo no existe');

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

            Log::info('Steps recibidos:', $request->steps);

            foreach ($request->steps as $stepData) {

                // ACTUALIZAR STEP
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
                            'tips' => $stepData['tips'] ?? [],   // ← ← AQUI
                        ]);

                        $stepIdsInRequest[] = $step->id;
                    }
                }

                // CREAR STEP NUEVO
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
                        'tips' => $stepData['tips'] ?? [],   // ← ← AQUI
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
                    'pregunta' => $pregunta['pregunta'],
                    'opciones' => $pregunta['opciones'] ?? [],
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
                    if (!$imagen)
                        continue;

                    $imagen->description = $imgData['description'] ?? $imagen->description;

                    $uploaded = $request->file("imagenes.$index.file");
                    if ($uploaded) {
                        if ($imagen->image_path && Storage::disk('public')->exists($imagen->image_path)) {
                            Storage::disk('public')->delete($imagen->image_path);
                        }
                        $imagen->image_path = $uploaded->store('modulos/imagenes', 'public');
                    }

                    $imagen->save();
                } else {
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
}
