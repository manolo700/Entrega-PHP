@extends('layouts.app')

@section('title', 'Nueva Auditoría')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-xl-6">

        {{-- ── Breadcrumb ── --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="{{ route('audits.index') }}" class="text-decoration-none">
                        <i class="bi bi-house me-1"></i>Auditorías
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Nueva Auditoría</li>
            </ol>
        </nav>

        {{-- ── Bloque de errores de validación ── --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start gap-3 rounded-3 mb-4 border-0 shadow-sm"
                 role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 text-danger mt-1 flex-shrink-0"></i>
                <div class="flex-grow-1">
                    <strong class="d-block mb-1">Por favor corrige los siguientes errores:</strong>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        {{-- ── Tarjeta del formulario ── --}}
        <div class="card shadow-sm border-0 rounded-4">

            {{-- Cabecera --}}
            <div class="card-header bg-white py-3 border-bottom px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3"
                         style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-plus-lg fs-5"></i>
                    </div>
                    <div>
                        <h5 class="card-title fw-bold mb-0 text-dark">Registrar Nueva Auditoría</h5>
                        <small class="text-muted">Completa los campos requeridos para dar de alta el registro.</small>
                    </div>
                </div>
            </div>

            {{-- Cuerpo del formulario --}}
            <div class="card-body p-4">
                <form action="{{ route('audits.store') }}" method="POST" novalidate>
                    @csrf

                    {{-- ── Título ── --}}
                    <div class="mb-4">
                        <label for="titulo" class="form-label">
                            Título de la Auditoría <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-tag-fill"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control border-start-0 @error('titulo') is-invalid @enderror"
                                id="titulo"
                                name="titulo"
                                value="{{ old('titulo') }}"
                                placeholder="Ej: Auditoría de Seguridad Perimetral 2024"
                                maxlength="255"
                                autofocus
                            >
                            @error('titulo')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span class="form-text">Mínimo 5 caracteres, máximo 255.</span>
                            <span class="char-counter small" id="titulo-counter">0 / 255</span>
                        </div>
                    </div>

                    {{-- ── Estado ── --}}
                    <div class="mb-4">
                        <label for="estado" class="form-label">
                            Estado Inicial <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-activity"></i>
                            </span>
                            <select
                                class="form-select border-start-0 @error('estado') is-invalid @enderror"
                                id="estado"
                                name="estado"
                            >
                                <option value="" disabled {{ old('estado') ? '' : 'selected' }}>
                                    — Selecciona un estado —
                                </option>
                                <option value="pendiente"  {{ old('estado', 'pendiente') === 'pendiente'  ? 'selected' : '' }}>
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
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- ── Descripción ── --}}
                    <div class="mb-4">
                        <label for="descripcion" class="form-label">
                            Descripción / Observaciones
                            <span class="text-muted fw-normal">(opcional)</span>
                        </label>
                        <textarea
                            class="form-control @error('descripcion') is-invalid @enderror"
                            id="descripcion"
                            name="descripcion"
                            rows="5"
                            maxlength="2000"
                            placeholder="Detalla el alcance, los objetivos o los hallazgos preliminares de esta auditoría..."
                        >{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <div class="d-flex justify-content-between mt-1">
                            <span class="form-text">Si se proporciona, debe tener mínimo 10 caracteres.</span>
                            <span class="char-counter small" id="descripcion-counter">0 / 2000</span>
                        </div>
                    </div>

                    {{-- ── Botones ── --}}
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

@section('scripts')
<script>
    // ── Contador de caracteres en tiempo real ──────────────────────
    function setupCharCounter(inputId, counterId, max, warnAt) {
        const input   = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        if (!input || !counter) return;

        function update() {
            const len = input.value.length;
            counter.textContent = len + ' / ' + max;
            counter.classList.remove('warn', 'error');
            if (len >= max)       counter.classList.add('error');
            else if (len >= warnAt) counter.classList.add('warn');
        }
        input.addEventListener('input', update);
        update(); // inicializar con el valor de old()
    }

    document.addEventListener('DOMContentLoaded', function () {
        setupCharCounter('titulo',      'titulo-counter',      255, 220);
        setupCharCounter('descripcion', 'descripcion-counter', 2000, 1800);
    });
</script>
@endsection
