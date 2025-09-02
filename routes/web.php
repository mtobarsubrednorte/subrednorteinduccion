<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Admin\ReportController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// 🔒 Rutas protegidas por login
Route::middleware(['auth'])->group(function() {
    Route::get('/pages/home', function () {
        return view('pages.home');
    })->name('pages.home');

    Route::get('/pages/perfil', function () {
        return view('pages.perfil');
    })->name('pages.perfil');

    Route::get('modules/module1', function () {
        return view('modules.module1');
    })->name('modules.module1');
    // Módulos
    Route::get('/modules/bienvenida', [ModuleController::class, 'bienvenida'])->name('modules.bienvenida');
    Route::get('/modules/gestion-territorial', [ModuleController::class, 'gestionTerritorial'])->name('modules.gestion_territorial');
    Route::get('/modules/aplicativo-gitapps', [ModuleController::class, 'aplicativoGitapps'])->name('modules.aplicativo_gitapps');
    Route::get('/modules/final', [ModuleController::class, 'final'])->name('modules.final');

    Route::get('/modules/{module}', [ModuleController::class, 'show'])->name('modules.show');
    Route::post('/modules/{module}/completar', [ModuleController::class, 'complete'])->name('modules.complete');

    // Quiz
    //Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.show');
    //Route::post('/quiz/{quiz}/submit', [QuizController::class, 'submit'])->name('quiz.submit');

    // Certificado
    //Route::get('/certificado', [CertificateController::class, 'generate'])->name('certificate.generate');
});

// 🔒 Admin
Route::middleware(['auth','admin'])->prefix('admin')->group(function() {
    //Route::get('/reportes', [ReportController::class, 'index'])->name('admin.reportes');
});

// Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');