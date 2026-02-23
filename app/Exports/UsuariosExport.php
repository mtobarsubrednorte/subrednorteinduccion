<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsuariosExport implements FromView
{
    protected $subred;

    public function __construct($subred)
    {
        $this->subred = $subred;
    }

    public function view(): View
    {
        $totalModulos = DB::table('modulos')->count();

        $usuarios = User::with('profile')
            ->where('subred', $this->subred)
            ->get()
            ->map(function ($user) use ($totalModulos) {

                // =========================
                // MÓDULOS APROBADOS
                // =========================
                $completados = DB::table('modulo_user')
                    ->where('user_id', $user->id)
                    ->where('aprobado', 1)
                    ->count();

                $user->progreso = $totalModulos > 0
                    ? round(($completados / $totalModulos) * 100, 1)
                    : 0;

                // =========================
                // FECHA INICIO
                // =========================
                $user->inicio_curso = DB::table('modulo_user')
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'ASC')
                    ->value('created_at');

                // =========================
                // FECHA FIN
                // =========================
                $user->fin_curso = null;

                if ($user->progreso == 100) {
                    $user->fin_curso = DB::table('modulo_user')
                        ->where('user_id', $user->id)
                        ->where('aprobado', 1)
                        ->orderBy('updated_at', 'DESC')
                        ->value('updated_at');
                }

                // =========================
                // ESTADO CURSO
                // =========================
                $user->estado_curso =
                    $user->progreso == 0 ? 'No iniciado' :
                    ($user->progreso == 100 ? 'Finalizado' : 'En progreso');

                // =========================
                // DÍAS PARA FINALIZAR
                // =========================
                $user->dias_finalizacion = null;
                if ($user->inicio_curso && $user->fin_curso) {
                    $user->dias_finalizacion = Carbon::parse($user->inicio_curso)
                        ->diffInDays($user->fin_curso);
                }

                // =========================
                // DÍAS EN CURSO
                // =========================
                $user->dias_en_curso = null;
                if ($user->inicio_curso && !$user->fin_curso) {
                    $user->dias_en_curso = Carbon::parse($user->inicio_curso)
                        ->diffInDays(now());
                }

                // =========================
                // ÚLTIMA ACTIVIDAD
                // =========================
                $user->ultima_actividad = DB::table('modulo_user')
                    ->where('user_id', $user->id)
                    ->orderBy('updated_at', 'DESC')
                    ->value('updated_at');

                // =========================
                // CERTIFICADOS
                // =========================
                $user->certificados = DB::table('certificates')
                    ->where('user_id', $user->id)
                    ->count();

                return $user;
            });

        return view('exports.usuarios', [
            'usuarios' => $usuarios,
            'subred' => $this->subred
        ]);
    }
}