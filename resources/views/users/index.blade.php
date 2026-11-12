@extends('layouts.app')

@section('title', 'Gestión de Usuarios — Módulo Accounting')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-7">
        <h2 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
            <i class="bi bi-people-fill text-primary"></i>
            Gestión de Usuarios
        </h2>
        <p class="text-secondary mb-0">
            Administración de cuentas, asignación de roles y control de acceso del Módulo Accounting.
        </p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0">
        @can('users.create')
            <a href="{{ route('users.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Registrar Nuevo Usuario
            </a>
        @endcan
    </div>
</div>

<!-- Filtros y Búsqueda -->
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('users.index') }}" class="row g-2 align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control border-start-0 ps-0"
                           placeholder="Buscar por nombre o correo electrónico...">
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <select name="role_id" class="form-select">
                    <option value="">Todos los Roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-secondary px-3 w-100">
                    <i class="bi bi-funnel me-1"></i> Filtrar
                </button>
                @if (request()->hasAny(['search', 'role_id']))
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-2" title="Limpiar filtros">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Tabla de Usuarios -->
<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="ps-4">Usuario</th>
                    <th scope="col">Rol Asignado</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Fecha Registro</th>
                    <th scope="col" class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold shadow-sm"
                                     style="width: 42px; height: 42px; background: linear-gradient(135deg, #0284c7, #6366f1); font-size: 1rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('users.show', $user) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ $user->name }}
                                        @if (Auth::id() === $user->id)
                                            <span class="badge bg-secondary-subtle text-secondary ms-1 small">Tú</span>
                                        @endif
                                    </a>
                                    <div class="small text-muted">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($user->role)
                                @php
                                    $badgeClass = match($user->role->name) {
                                        'admin'   => 'bg-danger-subtle text-danger border-danger-subtle',
                                        'auditor' => 'bg-primary-subtle text-primary border-primary-subtle',
                                        default   => 'bg-secondary-subtle text-secondary border-secondary-subtle',
                                    };
                                @endphp
                                <span class="badge border px-3 py-1 rounded-pill {{ $badgeClass }}">
                                    <i class="bi bi-shield-check me-1"></i>{{ $user->role->display_name }}
                                </span>
                            @else
                                <span class="badge bg-light text-muted border">Sin Rol</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->isActive())
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                    <i class="bi bi-check-circle-fill me-1"></i> Activo
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill">
                                    <i class="bi bi-dash-circle-fill me-1"></i> Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="small text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '—' }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('users.show', $user) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Ver Detalle y Permisos">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @can('users.edit')
                                    <a href="{{ route('users.edit', $user) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Editar Usuario">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                @endcan

                                @can('users.delete')
                                    @if (Auth::id() !== $user->id)
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteUserModal"
                                                data-action="{{ route('users.destroy', $user) }}"
                                                data-name="{{ $user->name }}"
                                                title="Eliminar Usuario">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-people display-4 d-block mb-3 text-secondary opacity-50"></i>
                            <h5 class="fw-semibold">No se encontraron usuarios</h5>
                            <p class="small mb-0">Intenta con otro término de búsqueda o crea uno nuevo.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    @endif
</div>

<!-- Modal Confirmar Eliminación de Usuario -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger bg-opacity-10 border-0">
                <h5 class="modal-title fw-bold text-danger d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-2">¿Estás seguro de que deseas eliminar permanentemente al usuario:</p>
                <p class="fw-bold text-dark fs-5 mb-3" id="deleteUserName">—</p>
                <div class="alert alert-danger small py-2 px-3 rounded-3 mb-0">
                    <i class="bi bi-info-circle-fill me-1"></i> Esta acción no se puede deshacer. Se revocarán todas sus sesiones de inmediato.
                </div>
            </div>
            <div class="modal-footer border-0 p-3 bg-light">
                <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteUserForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 shadow-sm">
                        <i class="bi bi-trash3 me-1"></i> Sí, eliminar usuario
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('deleteUserModal');
        const form  = document.getElementById('deleteUserForm');
        const nameDisplay = document.getElementById('deleteUserName');

        if (modal) {
            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const action = button.getAttribute('data-action');
                const name   = button.getAttribute('data-name');

                form.action = action;
                nameDisplay.textContent = name;
            });
        }
    });
</script>
@endsection

