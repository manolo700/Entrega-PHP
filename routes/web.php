<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuditTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas / Invitados (Guest)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren Autenticación y Prevención de Caché)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'prevent-back'])->group(function () {

    // Cierre de sesión (invalida la sesión actual y regenera token CSRF)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Redirección raíz al panel principal
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Panel de control (Dashboard)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('permission:dashboard.view');

    // Módulo Accounting: Gestión de Usuarios (CRUD completo)
    Route::resource('users', UserController::class);

    // Módulo de Auditorías (CRUD completo)
    Route::resource('audits', AuditController::class);

    // Módulo de Tipos de Auditoría (Normas ISO)
    Route::resource('audit-types', AuditTypeController::class);
});
