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
                // Progreso general (porcentaje de módulos completados)
                $totalModulos = DB::table('modulos')->count();
                $completados = DB::table('modulo_user')
                    ->where('user_id', $user->id)
                    ->where('aprobado', 1)
                    ->count();

                $user->progreso = $totalModulos > 0
                    ? round(($completados / $totalModulos) * 100, 1)
                    : 0;

                // Certificados emitidos
                $user->certificados = DB::table('certificates')
                    ->where('user_id', $user->id)
                    ->count();

                $user->document_number = $user->document_number ?? 'No registrado';
                $user->gender = $user->gender ?? 'No registrado';


                return $user;
            });

        return view('exports.usuarios', [
            'usuarios' => $usuarios,
            'subred' => $this->subred
        ]);
    }
}
