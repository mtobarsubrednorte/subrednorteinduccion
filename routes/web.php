<?php

use App\Http\Controllers\Modules;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\PerfilController;  
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// 🔒 Rutas protegidas por login - PARA USUARIOS NORMALES
Route::middleware(['auth'])->group(function () {

    // Dashboard principal para usuarios normales
    Route::get('/pages/home', function () {
        return view('pages.home');
    })->name('pages.home');

    Route::get('/pages/perfil', [PerfilController::class, 'index'])->name('pages.perfil');

    // Módulos de aprendizaje
    Route::get('modules/module1', [Modules::class, 'showModulos'])->name('modules.module1');

    Route::get('modules/module2', function () {
        return view('modules.module2');
    })->name('modules.module2');

    Route::get('modules/module4', function () {
        return view('modules.module4');
    })->name('modules.module4');

    Route::get('/modules/bienvenida', [ModuleController::class, 'bienvenida'])->name('modules.bienvenida');
    Route::get('/modules/gestion-territorial', [ModuleController::class, 'gestionTerritorial'])->name('modules.gestion_territorial');
    Route::get('/modules/aplicativo-gitapps', [ModuleController::class, 'aplicativoGitapps'])->name('modules.aplicativo_gitapps');
    Route::get('/modules/final', [ModuleController::class, 'final'])->name('modules.final');

    Route::get('/modules/{module}', [ModuleController::class, 'show'])->name('modules.show');
    Route::post('/modules/{module}/completar', [ModuleController::class, 'complete'])->name('modules.complete');

    Route::post('/modulos/{modulo}/responder', [Modules::class, 'responder'])
        ->name('modulo.responder');

    Route::post('/steps/complete', [Modules::class, 'markComplete'])
        ->middleware('auth')
        ->name('steps.complete');

    Route::get('/certificado/download', [CertificateController::class, 'download'])->name('certificate.download');

    // Quiz
    // Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.show');
    // Route::post('/quiz/{quiz}/submit', [QuizController::class, 'submit'])->name('quiz.submit');

    // Certificado
    // Route::get('/certificado', [CertificateController::class, 'generate'])->name('certificate.generate');
});

// 🔒 RUTAS EXCLUSIVAS PARA ADMINISTRADORES


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard principal de administración
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::patch('/usuarios/{id}/toggle', [DashboardController::class, 'toggleEstado'])->name('usuarios.toggle');
    Route::get('/usuarios', [DashboardController::class, 'searchUsuarios'])->name('usuarios.index');
    Route::post('/admin/modulos', [DashboardController::class, 'storeModulo'])->name('modulos.store');






});


// Home (ruta por defecto de Laravel - puedes mantenerla o redirigirla)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');