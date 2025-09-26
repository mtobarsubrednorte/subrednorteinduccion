<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\AdminController;

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

    Route::get('/pages/perfil', function () {
        return view('pages.perfil');
    })->name('pages.perfil');

    // Módulos de aprendizaje
    Route::get('modules/module1', function () {
        return view('modules.module1');
    })->name('modules.module1');

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

    // Quiz
    // Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.show');
    // Route::post('/quiz/{quiz}/submit', [QuizController::class, 'submit'])->name('quiz.submit');

    // Certificado
    // Route::get('/certificado', [CertificateController::class, 'generate'])->name('certificate.generate');
});

// 🔒 RUTAS EXCLUSIVAS PARA ADMINISTRADORES
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Dashboard principal de administración
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Reportes (ya tienes esta ruta comentada)
    Route::get('/reportes', [ReportController::class, 'index'])->name('admin.reportes');

    // Puedes agregar más rutas de admin aquí
    Route::get('/usuarios', function () {
        return view('admin.usuarios');
    })->name('admin.usuarios');

    Route::get('/estadisticas', function () {
        return view('admin.estadisticas');
    })->name('admin.estadisticas');
});

// Home (ruta por defecto de Laravel - puedes mantenerla o redirigirla)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');