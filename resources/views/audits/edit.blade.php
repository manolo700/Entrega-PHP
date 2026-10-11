@extends('layouts.app')

@section('title', 'Editar Auditoría #' . $audit->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- Navegación tipo Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('audits.index') }}" class="text-decoration-none">Auditorías</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar Auditoría #{{ $audit->id }}</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-warning text-dark p-2 rounded-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h5 class="card-title fw-bold mb-0 text-dark">Editar Auditoría: {{ $audit->titulo }}</h5>
                        <small class="text-muted">Modifica los datos correspondientes al registro #{{ $audit->id }}.</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('audits.update', $audit) }}" method="POST">
                    @csrf
                    @method('PUT')

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
                                value="{{ old('titulo', $audit->titulo) }}" 
                                placeholder="Ej: Auditoría de Seguridad Perimetral y Firewall"
                                required
                                autofocus
                            >
                            @error('titulo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="mb-3">
                        <label for="estado" class="form-label fw-semibold">
                            Estado <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-activity"></i></span>
                            <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                <option value="pendiente" {{ old('estado', $audit->estado) === 'pendiente' ? 'selected' : '' }}>
                                    🟡 Pendiente
                                </option>
                                <option value="en_proceso" {{ old('estado', $audit->estado) === 'en_proceso' ? 'selected' : '' }}>
                                    🔵 En Proceso
                                </option>
                                <option value="completado" {{ old('estado', $audit->estado) === 'completado' ? 'selected' : '' }}>
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
                            placeholder="Detalles sobre el alcance, objetivos o hallazgos..."
                        >{{ old('descripcion', $audit->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('audits.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning px-4 shadow-sm text-dark fw-semibold">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Auditoría
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
