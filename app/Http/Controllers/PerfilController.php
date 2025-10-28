<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;

class PerfilController extends Controller
{
     public function index()
    {
        $user = Auth::user();

        // Obtener los certificados del usuario (si usas la tabla 'certificates')
        $certificates = Certificate::where('user_id', $user->id)->get();

        // Puedes enviar más datos si los necesitas
        return view('pages.perfil', [
            'user' => $user,
            'certificates' => $certificates,
        ]);
    }
}
