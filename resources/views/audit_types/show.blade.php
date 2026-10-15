@extends('layouts.app')

@section('title', 'Norma #' . $tipo->id . ' — ' . $tipo->nombre_norma)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="{{ route('audit-types.index') }}" class="text-decoration-none">
                        <i class="bi bi-bookmark-check me-1"></i>Tipos de Auditoría
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Norma #{{ $tipo->id }}
                </li>
            </ol>
        </nav>

        {{-- tarjeta de detalle --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">

            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3"
                         style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-award fs-5"></i>
                    </div>
                    <div>
                        <h5 class="card-title fw-bold mb-0 text-dark">
                            Detalle de la Norma <span class="text-muted fw-normal">#{{ $tipo->id }}</span>
                        </h5>
                        <small class="text-muted">Información del estándar de auditoría.</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">

                {{-- nombre de la norma --}}
                <div class="mb-4">
                    <label class="text-muted small text-uppercase fw-bold tracking-wide d-block mb-1">
                        Nombre de la Norma
                    </label>
                    <h3 class="fw-bold text-dark mb-0 lh-sm">{{ $tipo->nombre_norma }}</h3>
                </div>

                {{-- descripcion --}}
                <div class="mb-4">
                    <label class="text-muted small text-uppercase fw-bold d-block mb-1">
                        Descripción / ¿Qué evalúa?
                    </label>
                    <div class="p-3 bg-light rounded-3 text-secondary lh-base border">
                        {{ $tipo->descripcion }}
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">

                {{-- fechas --}}
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 text-muted small">
                            <i class="bi bi-calendar-plus text-primary fs-6"></i>
                            <div>
                                <span class="d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Fecha de Creación</span>
                                <span class="text-dark fw-semibold">
                                    {{ $tipo->created_at ? $tipo->created_at->format('d/m/Y — h:i A') : 'No registrada' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 text-muted small">
                            <i class="bi bi-arrow-clockwise text-primary fs-6"></i>
                            <div>
                                <span class="d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Última Modificación</span>
                                <span class="text-dark fw-semibold">
                                    {{ $tipo->updated_at ? $tipo->updated_at->format('d/m/Y — h:i A') : 'Sin cambios' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-footer bg-white py-3 px-4 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                <a href="{{ route('audit-types.index') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Listado
                </a>

                <div class="d-flex gap-2">
                    <a href="{{ route('audit-types.edit', $tipo) }}" class="btn btn-outline-primary btn-sm px-3 rounded-3">
                        <i class="bi bi-pencil-square me-1"></i> Editar Norma
                    </a>
                    <button type="button"
                            class="btn btn-outline-danger btn-sm px-3 rounded-3"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-action="{{ route('audit-types.destroy', $tipo) }}"
                            data-title="{{ $tipo->nombre_norma }}">
                        <i class="bi bi-trash3 me-1"></i> Eliminar
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
