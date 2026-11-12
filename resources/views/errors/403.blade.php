@extends('layouts.app')

@section('title', '403 — Acceso Denegado')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card border-0 shadow-lg text-center p-4 p-md-5" style="border-radius: 1.25rem;">
            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 rounded-circle" style="width: 90px; height: 90px;">
                    <i class="bi bi-shield-x text-danger" style="font-size: 3rem;"></i>
                </div>
            </div>

            <div class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-semibold mb-3 d-inline-block mx-auto">
                <i class="bi bi-lock-fill me-1"></i> HTTP 403 — Prohibido / Sin Autorización
            </div>

            <h2 class="fw-bold text-dark mb-2">Acceso Denegado</h2>
            <p class="text-secondary mb-4">
                {{ $exception->getMessage() ?: 'No cuentas con los permisos suficientes en el backend para consultar o ejecutar operaciones en esta sección.' }}
            </p>

            @auth
                <div class="p-3 bg-light rounded-3 mb-4 text-start border">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="small text-muted fw-semibold">Usuario en sesión:</span>
                        <span class="fw-bold text-dark">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="small text-muted fw-semibold">Rol asignado:</span>
                        <span class="badge bg-primary px-3 py-1 rounded-pill">
                            {{ Auth::user()->role ? Auth::user()->role->display_name : 'Sin rol' }}
                        </span>
                    </div>
                </div>
            @endauth

            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Regresar al Dashboard
                </a>
                <a href="{{ route('audits.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                    <i class="bi bi-list-ul me-1"></i> Ver Auditorías
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

