<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuditController;

// Redireccionar la ruta raíz hacia el listado de auditorías
Route::redirect('/', '/audits');

// Rutas tipo Resource para el CRUD de Auditorías
Route::resource('audits', AuditController::class);
