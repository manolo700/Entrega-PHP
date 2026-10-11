@extends('layouts.app')

@section('title', 'Nueva Auditoría')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- Navegación tipo Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('audits.index') }}" class="text-decoration-none">Auditorías</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nueva Auditoría</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary text-white p-2 rounded-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                    <div>
                        <h5 class="card-title fw-bold mb-0 text-dark">Registrar Nueva Auditoría</h5>
                        <small class="text-muted">Ingresa los datos requeridos para dar de alta una auditoría.</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('audits.store') }}" method="POST">
                    @csrf

                    <!-- Título -->
                    <div class="mb-3">
                        <label for="titulo" class="form-label fw-semibold">
                            Título de la Auditoría <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-tag"></i></span>
                            <input 
                                type="text" 
                                class="form-control @error('titulo') is-invalid @enderror" 
                                id="titulo" 
                                name="titulo" 
                                value="{{ old('titulo') }}" 
                                placeholder="Ej: Auditoría de Seguridad Perimetral y Firewall"
                                required
                                autofocus
                            >
                            @error('titulo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">Asigna un nombre descriptivo y claro a la auditoría.</div>
                    </div>

                    <!-- Estado -->
                    <div class="mb-3">
                        <label for="estado" class="form-label fw-semibold">
                            Estado Inicial <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-activity"></i></span>
                            <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                <option value="pendiente" {{ old('estado', 'pendiente') === 'pendiente' ? 'selected' : '' }}>
                                    🟡 Pendiente
                                </option>
                                <option value="en_proceso" {{ old('estado') === 'en_proceso' ? 'selected' : '' }}>
                                    🔵 En Proceso
                                </option>
                                <option value="completado" {{ old('estado') === 'completado' ? 'selected' : '' }}>
                                    🟢 Completado
                                </option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold">
                            Descripción / Observaciones
                        </label>
                        <textarea 
                            class="form-control @error('descripcion') is-invalid @enderror" 
                            id="descripcion" 
                            name="descripcion" 
                            rows="4" 
                            placeholder="Detalles sobre el alcance, objetivos o hallazgos preliminares..."
                        >{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Campo opcional. Puedes añadir detalles en cualquier momento.</div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('audits.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-check2-circle me-1"></i> Guardar Auditoría
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
