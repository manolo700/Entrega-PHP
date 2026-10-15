<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuditTypeController;
use App\Http\Controllers\DashboardController;

// Redireccionar la ruta raíz hacia el listado de auditorías
Route::redirect('/', '/audits');

// Panel de control con estadísticas de las auditorías
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rutas tipo Resource para el CRUD de Auditorías
Route::resource('audits', AuditController::class);

// Rutas tipo Resource para el CRUD de Tipos de Auditoría (Normas ISO)
Route::resource('audit-types', AuditTypeController::class);