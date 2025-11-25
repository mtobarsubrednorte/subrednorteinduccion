<?php

namespace App\Http\Controllers;

use App\Models\Modulos;
use Illuminate\Http\Request;
use App\Models\Step;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Certificate;

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
}
