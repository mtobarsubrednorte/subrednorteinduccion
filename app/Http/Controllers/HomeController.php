<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * Aplica el middleware auth para proteger todas las rutas de este controlador.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * Ahora redirige automáticamente al módulo "Bienvenida Mas Bienestar"
     * en lugar de la vista home.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Redirige al módulo de Bienvenida al iniciar sesión
        return redirect()->route('pages.home');
    }
}