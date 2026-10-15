<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuditTypeController;

// Redireccionar la ruta raíz hacia el listado de auditorías
Route::redirect('/', '/audits');

// Rutas tipo Resource para el CRUD de Auditorías
Route::resource('audits', AuditController::class);

// Rutas tipo Resource para el CRUD de Tipos de Auditoría (Normas ISO)
Route::resource('audit-types', AuditTypeController::class);

