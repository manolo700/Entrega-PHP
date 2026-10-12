@extends('layouts.app')

@section('title', 'Auditoría #' . $audit->id . ' — ' . $audit->titulo)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- ── Breadcrumb ── --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="{{ route('audits.index') }}" class="text-decoration-none">
                        <i class="bi bi-house me-1"></i>Auditorías
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Auditoría #{{ $audit->id }}
                </li>
            </ol>
        </nav>

        {{-- ══════════ Tarjeta principal de detalle ══════════ --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">

            {{-- Cabecera --}}
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-info bg-opacity-10 text-info p-2 rounded-3"
                         style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-file-earmark-text fs-5"></i>
                    </div>
                    <div>
                        <h5 class="card-title fw-bold mb-0 text-dark">
                            Detalle — Auditoría <span class="text-muted fw-normal">#{{ $audit->id }}</span>
                        </h5>
                        <small class="text-muted">Información completa del registro.</small>
                    </div>
                </div>

                {{-- Badge de estado --}}
                @if ($audit->estado === 'completado')
                    <span class="badge badge-status badge-status-completado fs-6">
                        <i class="bi bi-check-circle-fill me-1"></i> Completado
                    </span>
                @elseif ($audit->estado === 'en_proceso')
                    <span class="badge badge-status badge-status-en_proceso fs-6">
                        <i class="bi bi-arrow-repeat me-1"></i> En Proceso
                    </span>
                @else
                    <span class="badge badge-status badge-status-pendiente fs-6">
                        <i class="bi bi-clock-history me-1"></i> Pendiente
                    </span>
                @endif
            </div>

            {{-- Cuerpo --}}
            <div class="card-body p-4">

                {{-- Título --}}
                <div class="mb-4">
                    <label class="text-muted small text-uppercase fw-bold tracking-wide d-block mb-1">
                        <i class="bi bi-tag me-1"></i>Título de la Auditoría
                    </label>
                    <h3 class="fw-bold text-dark mb-0 lh-sm">{{ $audit->titulo }}</h3>
                </div>

                {{-- Descripción --}}
                <div class="mb-4">
                    <label class="text-muted small text-uppercase fw-bold d-block mb-1">
                        <i class="bi bi-card-text me-1"></i>Descripción / Observaciones
                    </label>
                    <div class="p-3 bg-light rounded-3 border text-secondary lh-lg"
                         style="min-height: 90px; white-space: pre-line; font-size: 0.9375rem;">
                        {{ $audit->descripcion ?: 'No se especificó ninguna descripción para esta auditoría.' }}
                    </div>
                </div>

                {{-- Metadatos --}}
                <div class="row g-3 py-3 px-2 bg-light bg-opacity-60 rounded-3 border mb-4">
                    <div class="col-sm-6">
                        <small class="text-muted d-flex align-items-center gap-1 mb-1">
                            <i class="bi bi-calendar-plus"></i> Fecha de Creación
                        </small>
                        <span class="fw-semibold text-dark">
                            {{ $audit->created_at ? $audit->created_at->format('d/m/Y — h:i A') : 'N/D' }}
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-flex align-items-center gap-1 mb-1">
                            <i class="bi bi-clock-history"></i> Última Actualización
                        </small>
                        <span class="fw-semibold text-dark">
                            {{ $audit->updated_at ? $audit->updated_at->format('d/m/Y — h:i A') : 'N/D' }}
                        </span>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pt-2">
                    <a href="{{ route('audits.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Volver al Listado
                    </a>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('audits.edit', $audit) }}" class="btn btn-warning text-dark fw-semibold">
                            <i class="bi bi-pencil-square me-1"></i> Editar
                        </a>

                        {{-- Botón para abrir el modal de eliminación --}}
                        <button type="button"
                                class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-action="{{ route('audits.destroy', $audit) }}"
                                data-title="{{ $audit->titulo }}">
                            <i class="bi bi-trash3 me-1"></i> Eliminar
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
