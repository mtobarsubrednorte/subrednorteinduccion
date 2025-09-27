<?php

namespace App\Http\Controllers;

use App\Models\Modulos;
use Illuminate\Http\Request;

class Modules extends Controller
{
    public function showModulos()
    {
        $modulos = Modulos::with(['submodulos', 'recursos', 'preguntas'])
            ->whereNull('parent_id')
            ->get();
        return view('modules.module1', compact('modulos'));
    }

    public function responder(Request $request, Modulos $modulo)
    {
        $respuestasUsuario = $request->input('respuestas', []);
        $resultado = [];
        $correctas = 0;

        foreach ($modulo->preguntas as $pregunta) {
            $respuestaUsuario = $respuestasUsuario[$pregunta->id] ?? null;
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

        // ✅ Calificación (ejemplo sobre 10 puntos)
        $total = max(1, $modulo->preguntas->count());
        $calificacion = round(($correctas / $total) * 10);

        $aprobado = $calificacion >= 8;

        // Guardamos en la tabla
        \DB::table('modulo_user')->updateOrInsert(
            ['user_id' => auth()->id(), 'modulo_id' => $modulo->id],
            ['calificacion' => $calificacion, 'aprobado' => $aprobado, 'updated_at' => now(), 'created_at' => now()]
        );

        return redirect()->back()->with([
            'success' => "Terminaste el módulo {$modulo->title} con nota {$calificacion}/10. " . ($aprobado ? "¡Aprobaste! 🎉" : "No aprobaste 😢"),
            'resultado' => $resultado
        ]);
    }

}
