@extends('layouts.app')

@section('title', 'Registrar Nuevo Usuario — Módulo Accounting')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- Encabezado -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="{{ route('users.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-2">
                    <i class="bi bi-arrow-left"></i> Volver al listado de usuarios
                </a>
                <h2 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-person-plus-fill text-primary"></i>
                    Registrar Nuevo Usuario
                </h2>
            </div>
        </div>

        <!-- Tarjeta de Formulario -->
        <div class="card border-0 shadow-sm p-4 p-md-4">
            <form action="{{ route('users.store') }}" method="POST" novalidate>
                @csrf

                <!-- Nombre Completo -->
                <div class="mb-3">
                    <label for="name" class="form-label">
                        Nombre Completo <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text"
                               name="name"
                               id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Ej. Juan Pérez"
                               required>
                    </div>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Correo Electrónico -->
                <div class="mb-3">
                    <label for="email" class="form-label">
                        Correo Electrónico <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="ejemplo@auditorias.com"
                               required>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Rol del Usuario -->
                <div class="mb-3">
                    <label for="role_id" class="form-label">
                        Rol y Permisos Asignados <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted">
                            <i class="bi bi-shield-lock"></i>
                        </span>
                        <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                            <option value="">-- Selecciona un rol --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->display_name }} — {{ $role->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('role_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted small">
                        El rol define automáticamente los permisos que el usuario tendrá en el backend.
                    </div>
                </div>

                <!-- Estado Activo -->
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               role="switch"
                               name="active"
                               id="active"
                               value="1"
                               {{ old('active', '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="active">
                            Cuenta activa (permite el inicio de sesión)
                        </label>
                    </div>
                </div>

                <hr class="my-4 text-muted">

                <!-- Contraseña y Confirmación -->
                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-key me-1 text-primary"></i> Credenciales de Acceso
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="password" class="form-label">
                            Contraseña <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Mínimo 8 caracteres"
                                   required>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">
                            Confirmar Contraseña <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control"
                                   placeholder="Repite la contraseña"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4 rounded-pill">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> Guardar Usuario
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

