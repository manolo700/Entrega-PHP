@extends('layouts.app')

@section('title', 'Nueva Norma')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-xl-6">

        {{-- breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="{{ route('audit-types.index') }}" class="text-decoration-none">
                        <i class="bi bi-bookmark-check me-1"></i>Tipos de Auditoría
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Nueva Norma</li>
            </ol>
        </nav>

        {{-- errores de validacion --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start gap-3 rounded-3 mb-4 border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 text-danger mt-1 flex-shrink-0"></i>
                <div class="flex-grow-1">
                    <strong class="d-block mb-1">Corrige los siguientes errores:</strong>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        {{-- tarjeta del formulario --}}
        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white py-3 border-bottom px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3"
                         style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-plus-lg fs-5"></i>
                    </div>
                    <div>
                        <h5 class="card-title fw-bold mb-0 text-dark">Registrar Tipo de Auditoría</h5>
                        <small class="text-muted">Ingresa los datos de la norma o estándar.</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('audit-types.store') }}" method="POST" novalidate>
                    @csrf

                    {{-- nombre de la norma --}}
                    <div class="mb-3">
                        <label for="nombre_norma" class="form-label">
                            Nombre de la Norma / Estándar <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nombre_norma') is-invalid @enderror"
                               id="nombre_norma"
                               name="nombre_norma"
                               value="{{ old('nombre_norma') }}"
                               placeholder="Ej: ISO 14001:2015 - Gestión Ambiental"
                               maxlength="255"
                               required>
                        @error('nombre_norma')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- descripcion --}}
                    <div class="mb-4">
                        <label for="descripcion" class="form-label">
                            Descripción / ¿Qué evalúa? <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                  id="descripcion"
                                  name="descripcion"
                                  rows="4"
                                  placeholder="Explica brevemente qué aspectos evalúa esta norma (ej: procesos de calidad, impacto ambiental, seguridad de la información, etc.)."
                                  maxlength="1000"
                                  required>{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted small mt-1">
                            Detalla el objetivo y el alcance de los criterios a auditar.
                        </div>
                    </div>

                    {{-- botones --}}
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <a href="{{ route('audit-types.index') }}" class="btn btn-outline-secondary px-4 rounded-3">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary px-4 rounded-3 shadow-sm">
                            <i class="bi bi-check2-circle me-1"></i> Guardar Norma
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
