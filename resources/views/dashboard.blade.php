@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- ══════════════ Cabecera ══════════════ --}}
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h1 class="h3 fw-bold text-dark mb-1">
            <i class="bi bi-speedometer2 text-primary me-2"></i>Dashboard
        </h1>
        <p class="text-muted mb-0 small">
            Resumen general del estado de las auditorías registradas en el sistema.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="{{ route('audits.create') }}" class="btn btn-primary px-4 shadow-sm rounded-3">
            <i class="bi bi-plus-lg me-1"></i> Nueva Auditoría
        </a>
    </div>
</div>

{{-- ══════════════ Tarjetas de estadísticas ══════════════ --}}
<div class="row g-3 mb-4">

    {{-- Total --}}
    <div class="col-6 col-lg-3">
        <div class="card h-100 border-0 rounded-4">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center"
                     style="width:48px; height:48px;">
                    <i class="bi bi-journal-text fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Total</div>
                    <div class="fs-3 fw-bold text-dark lh-1">{{ $total }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pendientes --}}
    <div class="col-6 col-lg-3">
        <div class="card h-100 border-0 rounded-4">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:48px; height:48px; background:#fef3c7; color:#92400e;">
                    <i class="bi bi-clock-history fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Pendientes</div>
                    <div class="fs-3 fw-bold text-dark lh-1">{{ $pending }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- En proceso --}}
    <div class="col-6 col-lg-3">
        <div class="card h-100 border-0 rounded-4">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:48px; height:48px; background:#dbeafe; color:#1d4ed8;">
                    <i class="bi bi-arrow-repeat fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">En proceso</div>
                    <div class="fs-3 fw-bold text-dark lh-1">{{ $inProgress }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Completadas --}}
    <div class="col-6 col-lg-3">
        <div class="card h-100 border-0 rounded-4">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:48px; height:48px; background:#dcfce7; color:#15803d;">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Completadas</div>
                    <div class="fs-3 fw-bold text-dark lh-1">{{ $completed }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">

    {{-- ══════════════ Avance general (anillo de progreso) ══════════════ --}}
    <div class="col-lg-4">
        <div class="card h-100 border-0 rounded-4">
            <div class="card-header bg-white py-3">
                <i class="bi bi-pie-chart text-primary me-2"></i>Avance general
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                     style="width:150px; height:150px;
                            background: conic-gradient(#22c55e {{ $completedPercentage }}%, #e2e8f0 0);">
                    <div class="bg-white rounded-circle d-flex flex-column align-items-center justify-content-center"
                          style="width:112px; height:112px;">
                        <span class="fs-3 fw-bold text-dark lh-1">{{ round($completedPercentage) }}%</span>
                        <span class="text-muted" style="font-size:0.7rem;">completado</span>
                    </div>
                </div>
                <p class="text-muted small text-center mb-0">
                    <strong>{{ $lastWeek }}</strong>
                    {{ $lastWeek === 1 ? 'auditoría registrada' : 'auditorías registradas' }}
                    en los últimos 7 días.
                </p>
            </div>
        </div>
    </div>

    {{-- ══════════════ Distribución por estado ══════════════ --}}
    <div class="col-lg-8">
        <div class="card h-100 border-0 rounded-4">
            <div class="card-header bg-white py-3">
                <i class="bi bi-bar-chart-line text-primary me-2"></i>Distribución por estado
            </div>
            <div class="card-body py-4">

                @if ($total > 0)
                    {{-- Barra apilada --}}
                    <div class="progress mb-4" style="height: 14px; border-radius: 999px;">
                        <div class="progress-bar" role="progressbar"
                             style="width: {{ $completedPercentage }}%; background:#22c55e;"
                             title="Completadas"></div>
                        <div class="progress-bar" role="progressbar"
                             style="width: {{ $inProgressPercentage }}%; background:#3b82f6;"
                             title="En proceso"></div>
                        <div class="progress-bar" role="progressbar"
                             style="width: {{ $pendingPercentage }}%; background:#f59e0b;"
                             title="Pendientes"></div>
                    </div>

                    {{-- Leyenda --}}
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <span class="badge badge-status badge-status-completado">
                                <i class="bi bi-check-circle-fill me-1"></i>Completado
                            </span>
                            <div class="mt-2 fw-bold text-dark">{{ $completed }}
                                <span class="text-muted fw-normal small">({{ $completedPercentage }}%)</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <span class="badge badge-status badge-status-en_proceso">
                                <i class="bi bi-arrow-repeat me-1"></i>En Proceso
                            </span>
                            <div class="mt-2 fw-bold text-dark">{{ $inProgress }}
                                <span class="text-muted fw-normal small">({{ $inProgressPercentage }}%)</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <span class="badge badge-status badge-status-pendiente">
                                <i class="bi bi-clock-history me-1"></i>Pendiente
                            </span>
                            <div class="mt-2 fw-bold text-dark">{{ $pending }}
                                <span class="text-muted fw-normal small">({{ $pendingPercentage }}%)</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted display-5 d-block mb-2"></i>
                        <p class="text-muted small mb-0">Aún no hay auditorías para mostrar estadísticas.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ══════════════ Últimas auditorías ══════════════ --}}
<div class="card border-0 rounded-4 overflow-hidden">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-secondary">
            <i class="bi bi-clock-history text-primary me-2"></i>Últimas auditorías
        </span>
        <a href="{{ route('audits.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
            Ver todas <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Título</th>
                        <th style="width:150px;">Estado</th>
                        <th style="width:170px;">Fecha Registro</th>
                        <th class="text-end pe-4" style="width:80px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentAudits as $audit)
                        <tr>
                            <td class="ps-4 fw-semibold text-dark">
                                {{ Str::limit($audit->titulo, 60, '…') }}
                            </td>
                            <td>
                                @if ($audit->estado === 'completado')
                                    <span class="badge badge-status badge-status-completado">
                                        <i class="bi bi-check-circle-fill me-1"></i>Completado
                                    </span>
                                @elseif ($audit->estado === 'en_proceso')
                                    <span class="badge badge-status badge-status-en_proceso">
                                        <i class="bi bi-arrow-repeat me-1"></i>En Proceso
                                    </span>
                                @else
                                    <span class="badge badge-status badge-status-pendiente">
                                        <i class="bi bi-clock-history me-1"></i>Pendiente
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $audit->created_at ? $audit->created_at->format('d/m/Y H:i') : 'N/D' }}
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('audits.show', $audit) }}"
                                   class="btn btn-outline-info btn-sm" title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox display-5 d-block mb-2"></i>
                                No hay auditorías registradas todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection