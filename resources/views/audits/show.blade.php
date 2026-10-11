@extends('layouts.app')

@section('title', 'Detalles de la Auditoría #' . $audit->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- Navegación tipo Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('audits.index') }}" class="text-decoration-none">Auditorías</a></li>
                <li class="breadcrumb-item active" aria-current="page">Auditoría #{{ $audit->id }}</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-info bg-opacity-10 text-info p-2 rounded-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="bi bi-file-earmark-text fs-5"></i>
                    </div>
                    <div>
                        <h5 class="card-title fw-bold mb-0 text-dark">Detalle de Auditoría #{{ $audit->id }}</h5>
                        <small class="text-muted">Información completa del registro de auditoría</small>
                    </div>
                </div>

                <div>
                    @if ($audit->estado === 'completado')
                        <span class="badge badge-status-completado px-3 py-2 rounded-pill fs-6">
                            <i class="bi bi-check-circle-fill me-1"></i> Completado
                        </span>
                    @elseif ($audit->estado === 'en_proceso')
                        <span class="badge badge-status-en_proceso px-3 py-2 rounded-pill fs-6">
                            <i class="bi bi-arrow-repeat me-1"></i> En Proceso
                        </span>
                    @else
                        <span class="badge badge-status-pendiente px-3 py-2 rounded-pill fs-6">
                            <i class="bi bi-clock-history me-1"></i> Pendiente
                        </span>
                    @endif
                </div>
            </div>

            <div class="card-body p-4">
                <div class="mb-4">
                    <label class="text-muted small text-uppercase fw-bold">Título de la Auditoría</label>
                    <h3 class="fw-bold text-dark mt-1">{{ $audit->titulo }}</h3>
                </div>

                <div class="mb-4">
                    <label class="text-muted small text-uppercase fw-bold">Descripción u Observaciones</label>
                    <div class="p-3 bg-light rounded-3 border text-secondary mt-1" style="min-height: 90px; white-space: pre-line;">
                        {{ $audit->descripcion ?: 'No se especificó ninguna descripción u observación para esta auditoría.' }}
                    </div>
                </div>

                <div class="row g-3 py-3 border-top border-bottom mb-4 bg-light bg-opacity-50 rounded-2">
                    <div class="col-sm-6">
                        <small class="text-muted d-block"><i class="bi bi-calendar-plus me-1"></i> Fecha de Creación:</small>
                        <span class="fw-semibold">{{ $audit->created_at ? $audit->created_at->format('d/m/Y - h:i A') : 'N/D' }}</span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block"><i class="bi bi-clock-history me-1"></i> Última Actualización:</small>
                        <span class="fw-semibold">{{ $audit->updated_at ? $audit->updated_at->format('d/m/Y - h:i A') : 'N/D' }}</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('audits.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Volver al Listado
                    </a>

                    <div class="d-flex gap-2">
                        <a href="{{ route('audits.edit', $audit) }}" class="btn btn-warning text-dark fw-semibold">
                            <i class="bi bi-pencil-square me-1"></i> Editar
                        </a>

                        <form action="{{ route('audits.destroy', $audit) }}" method="POST" onsubmit="return confirm('¿Está seguro de que desea eliminar permanentemente esta auditoría?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash3 me-1"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
