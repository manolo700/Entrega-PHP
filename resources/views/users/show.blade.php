@extends('layouts.app')

@section('title', 'Detalle de Usuario — ' . $user->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">

        <!-- Encabezado -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="{{ route('users.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-2">
                    <i class="bi bi-arrow-left"></i> Volver al listado de usuarios
                </a>
                <h2 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-person-badge-fill text-primary"></i>
                    Ficha de Usuario &amp; Permisos
                </h2>
            </div>
            <div class="d-flex gap-2">
                @can('users.edit')
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning rounded-pill px-3 shadow-sm fw-semibold">
                        <i class="bi bi-pencil-square me-1"></i> Editar Usuario
                    </a>
                @endcan
            </div>
        </div>

        <!-- Tarjeta Principal del Usuario -->
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-4">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold shadow-sm flex-shrink-0"
                         style="width: 80px; height: 80px; background: linear-gradient(135deg, #0284c7, #6366f1); font-size: 2rem;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                            <h3 class="fw-bold text-dark mb-0">{{ $user->name }}</h3>
                            @if ($user->isActive())
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill small">
                                    <i class="bi bi-check-circle-fill me-1"></i> Cuenta Activa
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill small">
                                    <i class="bi bi-dash-circle-fill me-1"></i> Cuenta Inactiva
                                </span>
                            @endif
                            @if (Auth::id() === $user->id)
                                <span class="badge bg-primary px-2 py-1 rounded-pill small">Sesión Actual</span>
                            @endif
                        </div>
                        <p class="text-secondary mb-2">
                            <i class="bi bi-envelope me-1"></i> {{ $user->email }}
                        </p>
                        <div class="d-flex flex-wrap gap-3 small text-muted">
                            <span><i class="bi bi-calendar-check me-1"></i> Registrado: {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '—' }}</span>
                            <span><i class="bi bi-clock-history me-1"></i> Última actualización: {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desglose de Rol y Permisos de Backend -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom p-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-shield-lock-fill text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">Rol Asignado &amp; Permisos Validados en Backend</h5>
                </div>
                @if ($user->role)
                    <span class="badge bg-primary px-3 py-2 rounded-pill fs-6">
                        {{ $user->role->display_name }}
                    </span>
                @endif
            </div>
            <div class="card-body p-4">
                @if ($user->role)
                    <div class="alert alert-light border mb-4">
                        <div class="fw-bold text-dark mb-1">
                            <i class="bi bi-info-circle me-1 text-primary"></i> Alcance del Rol:
                        </div>
                        <p class="small text-secondary mb-0">{{ $user->role->description }}</p>
                    </div>

                    <h6 class="fw-bold text-dark mb-3">
                        <i class="bi bi-check-all me-1 text-success"></i> Permisos Habilitados en Controladores y Rutas:
                    </h6>

                    @php
                        // Si es admin tiene todos, sino los de su rol
                        $permissions = $user->isAdmin()
                            ? \App\Models\Permission::all()
                            : $user->role->permissions;
                        $grouped = $permissions->groupBy('module');
                    @endphp

                    <div class="row g-3">
                        @foreach ($grouped as $module => $perms)
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 bg-light bg-opacity-50 h-100">
                                    <div class="fw-bold text-dark mb-2 d-flex align-items-center justify-content-between">
                                        <span><i class="bi bi-folder2-open text-primary me-1"></i> Módulo: {{ $module }}</span>
                                        <span class="badge bg-secondary-subtle text-secondary small">{{ $perms->count() }} permisos</span>
                                    </div>
                                    <ul class="list-unstyled mb-0 small">
                                        @foreach ($perms as $perm)
                                            <li class="py-1 d-flex align-items-center justify-content-between border-bottom border-light">
                                                <div>
                                                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                                                    <span class="fw-medium text-dark">{{ $perm->display_name }}</span>
                                                    <div class="text-muted" style="font-size: 0.72rem;"><code>{{ $perm->name }}</code></div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Este usuario no tiene ningún rol asignado y por lo tanto no cuenta con permisos para operar en el sistema.
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

