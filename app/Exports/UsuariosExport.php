<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class UsuariosExport implements FromView
{
    protected $subred;

    public function __construct($subred)
    {
        $this->subred = $subred;
    }



public function view(): View
{
    $usuarios = User::with('profile')
        ->where('subred', $this->subred)
        ->get()
        ->map(function ($user) {

            // =========================
            // Total de módulos del curso
            // =========================
            $totalModulos = DB::table('modulos')->count();

            // =========================
            // Módulos aprobados por usuario
            // =========================
            $completados = DB::table('modulo_user')
                ->where('user_id', $user->id)
                ->where('aprobado', 1)
                ->count();

            // =========================
            // Progreso (%)
            // =========================
            $user->progreso = $totalModulos > 0
                ? round(($completados / $totalModulos) * 100, 1)
                : 0;

            // =========================
            // Fecha de inicio del curso
            // (primer módulo tocado)
            // =========================
            $user->inicio_curso = DB::table('modulo_user')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'ASC')
                ->value('created_at');

            // =========================
            // Fecha de finalización del curso
            // (solo si terminó todo)
            // =========================
            $user->fin_curso = null;

            if ($user->progreso === 100) {
                $user->fin_curso = DB::table('modulo_user')
                    ->where('user_id', $user->id)
                    ->where('aprobado', 1)
                    ->orderBy('updated_at', 'DESC')
                    ->value('updated_at');
            }

            // =========================
            // Certificados emitidos
            // =========================
            $user->certificados = DB::table('certificates')
                ->where('user_id', $user->id)
                ->count();

            // =========================
            // Datos opcionales
            // =========================
            $user->document_number = $user->document_number ?? 'No registrado';
            $user->gender = $user->gender ?? 'No registrado';

            return $user;
        });

    return view('exports.usuarios', [
        'usuarios' => $usuarios,
        'subred'   => $this->subred
    ]);
}

}
