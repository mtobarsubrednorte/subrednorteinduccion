<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\UserModuleProgress;

class ModuleController extends Controller
{
    // Método para mostrar cualquier módulo
    public function show(Module $module)
    {
        $user = Auth::user();

        $progress = UserModuleProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'module_id' => $module->id
            ],
            [
                'status' => 'in_progress'
            ]
        );

        return view('modules.show', compact('module','progress'));
    }

    // Método para marcar módulo como completado
    public function complete(Request $request, Module $module)
    {
        $user = Auth::user();

        // Actualiza o crea el progreso del módulo
        $progress = UserModuleProgress::updateOrCreate(
            ['user_id' => $user->id, 'module_id' => $module->id],
            ['status' => 'completed']
        );

        // Si la petición viene vía AJAX (fetch), devuelve JSON
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        // Si no es AJAX, redirige como antes
        return redirect()->route('modules.show', $module->id)
                         ->with('success','Módulo completado con éxito');
    }

    // Mostrar el módulo "Bienvenida Mas Bienestar"
    public function bienvenida()
    {
        $user = Auth::user();

        // Buscar el módulo por título
        $module = Module::where('title', 'Bienvenida Mas Bienestar')->firstOrFail();

        // Registrar progreso del usuario si no existe
        $progress = UserModuleProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'module_id' => $module->id
            ],
            [
                'status' => 'in_progress'
            ]
        );

        // Retornar la vista específica para este módulo
        return view('modules.bienvenida', compact('module','progress'));
    }
}