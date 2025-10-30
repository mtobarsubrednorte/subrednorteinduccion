<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;
use App\Models\Modulos;
use Illuminate\Support\Facades\DB;
use App\Models\User;    
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


class PerfilController extends Controller
{
     public function index()
        {

        $user = Auth::user();

        $certificates = Certificate::where('user_id', $user->id)->get();

        $modulos = Modulos::with(['submodulos', 'recursos', 'preguntas', 'steps', 'images'])
            ->whereNull('parent_id')
            ->get();

        $aprobados = DB::table('modulo_user')
            ->where('user_id', $user->id)
            ->where('aprobado', 1)
            ->pluck('modulo_id');

        // 🕒 Total de horas de formación (solo de módulos aprobados)
        $horasFormacion = DB::table('modulos')
            ->join('modulo_user', 'modulos.id', '=', 'modulo_user.modulo_id')
            ->where('modulo_user.user_id', $user->id)
            ->where('modulo_user.aprobado', 1)
            ->sum('modulos.duration');

        // 📊 Calificación promedio como progreso (0 a 10 → 0 a 100%)
        $calificacionPromedio = DB::table('modulo_user')
            ->where('user_id', $user->id)
            ->avg('calificacion');

        $progresoPromedio = $calificacionPromedio ? round($calificacionPromedio * 10, 1) : 0;

        $progresoPorModulo = DB::table('modulos')
            ->join('modulo_user', 'modulos.id', '=', 'modulo_user.modulo_id')
            ->where('modulo_user.user_id', $user->id)
            ->select(
                'modulos.id',
                'modulos.title',
                'modulos.description',
                'modulo_user.calificacion',
                DB::raw('(modulo_user.calificacion * 10) as progreso')
            )
            ->get();


        return view('pages.perfil', [
            'user' => $user,
            'certificates' => $certificates,
            'modulos' => $modulos,
            'aprobados' => $aprobados,
            'horasFormacion' => $horasFormacion,
            'progresoPromedio' => $progresoPromedio,
            'progresoPorModulo' => $progresoPorModulo,
        ]);
    }

 
    public function update(Request $request)
    {
        $user = Auth::user();

        // Identificar la sección que envía el formulario
        $section = $request->input('section');

        // Reglas base (usando sometimes para aceptar ausencias)
        $rules = [
            'name' => ['sometimes','required','string','max:255'],
            'document_number' => ['sometimes','nullable','string','max:50'],
            'gender' => ['sometimes','nullable','string','max:20'],
            'email' => ['sometimes','required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'subred' => ['sometimes','nullable','string','max:255'],
        ];

        // Validar SOLO los campos presentes en la petición
        $validated = $request->validate($rules);

        // $validated contiene únicamente los campos validados y presentes
        // Actualizamos solo lo que venga
        if (!empty($validated)) {
            User::where('id', $user->id)->update($validated);
            Log::info("Perfil actualizado para el usuario ID: " . $user->id);
            return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
        }

        return redirect()->back()->with('info', 'No se detectaron cambios.');
    }
}
