<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function bienvenida()
    {
        $module = (object)[
            'id' => 1,
            'title' => 'Bienvenida'
        ];
        return view('modules.bienvenida', compact('module'));
    }

    public function gestionTerritorial()
    {
        $module = (object)[
            'id' => 2,
            'title' => 'Gestión Territorial'
        ];
        return view('modules.gestion_territorial', compact('module'));
    }

    public function aplicativoGitapps()
    {
        $module = (object)[
            'id' => 3,
            'title' => 'Aplicativo GitApps'
        ];
        return view('modules.aplicativo_gitapps', compact('module'));
    }

    public function final()
    {
        $module = (object)[
            'id' => 4,
            'title' => 'Módulo Final'
        ];
        return view('modules.final', compact('module'));
    }

    public function show($module)
    {
        // Mapeamos los módulos según el parámetro
        $modules = [
            'bienvenida' => (object)[ 'id' => 1, 'title' => 'Bienvenida' ],
            'gestion-territorial' => (object)[ 'id' => 2, 'title' => 'Gestión Territorial' ],
            'aplicativo-gitapps' => (object)[ 'id' => 3, 'title' => 'Aplicativo GitApps' ],
            'final' => (object)[ 'id' => 4, 'title' => 'Módulo Final' ],
        ];

        if (!array_key_exists($module, $modules)) {
            abort(404, 'Módulo no encontrado');
        }

        return view('modules.show', ['module' => $modules[$module]]);
    }

    public function complete($module)
    {
        return redirect()->route('modules.show', $module)
            ->with('success', 'Módulo completado');
    }
}