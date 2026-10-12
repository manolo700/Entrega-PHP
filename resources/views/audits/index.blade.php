@extends('layouts.app')

@section('title', 'Listado de Auditorías')

@section('content')

{{-- ══════════════ Cabecera de sección ══════════════ --}}
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h1 class="h3 fw-bold text-dark mb-1">
            <i class="bi bi-journal-text text-primary me-2"></i>Listado de Auditorías
        </h1>
        <p class="text-muted mb-0 small">
            Gestión, seguimiento y control de auditorías registradas en el sistema.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="{{ route('audits.create') }}" class="btn btn-primary px-4 shadow-sm rounded-3">
            <i class="bi bi-plus-lg me-1"></i> Nueva Auditoría
        </a>
    </div>
</div>

{{-- ══════════════ Tarjeta Principal ══════════════ --}}
<div class="card shadow-sm border-0 rounded-4 overflow-hidden">

    {{-- Cabecera de la tarjeta --}}
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-secondary d-flex align-items-center gap-2">
            <i class="bi bi-table text-primary"></i> Registros de Auditoría
        </span>
        <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
            <i class="bi bi-database me-1 text-muted"></i>
            Total: <strong>{{ $audits->total() }}</strong> registros
        </span>
    </div>

    {{-- Tabla --}}
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 70px;"># ID</th>
                        <th style="min-width: 200px;">Título</th>
                        <th style="min-width: 250px;">Descripción</th>
                        <th style="width: 150px;">Estado</th>
                        <th style="width: 170px;">Fecha Registro</th>
                        <th class="text-end pe-4" style="width: 170px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($audits as $audit)
                        <tr>
                            {{-- ID --}}
                            <td class="ps-4">
                                <span class="badge bg-light text-secondary border fw-semibold">#{{ $audit->id }}</span>
                            </td>

                            {{-- Título --}}
                            <td>
                                <a href="{{ route('audits.show', $audit) }}"
                                   class="text-decoration-none fw-semibold text-dark stretched-link-custom"
                                   title="{{ $audit->titulo }}">
                                    {{ Str::limit($audit->titulo, 50, '…') }}
                                </a>
                            </td>

                            {{-- Descripción --}}
                            <td class="text-secondary small">
                                {{ Str::limit($audit->descripcion ?? 'Sin descripción adicional.', 80, '…') }}
                            </td>

                            {{-- Estado --}}
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

                            {{-- Fecha --}}
                            <td class="text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $audit->created_at ? $audit->created_at->format('d/m/Y H:i') : 'N/D' }}
                            </td>

                            {{-- Acciones --}}
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Acciones">
                                    {{-- Ver --}}
                                    <a href="{{ route('audits.show', $audit) }}"
                                       class="btn btn-outline-info"
                                       title="Ver detalle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    {{-- Editar --}}
                                    <a href="{{ route('audits.edit', $audit) }}"
                                       class="btn btn-outline-warning"
                                       title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    {{-- Eliminar (abre modal) --}}
                                    <button type="button"
                                            class="btn btn-outline-danger"
                                            title="Eliminar"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-action="{{ route('audits.destroy', $audit) }}"
                                            data-title="{{ $audit->titulo }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox text-muted display-4 d-block mb-3"></i>
                                    <h5 class="fw-semibold text-secondary">No hay auditorías registradas</h5>
                                    <p class="text-muted small mb-3">Comienza creando la primera auditoría en el sistema.</p>
                                    <a href="{{ route('audits.create') }}"
                                       class="btn btn-primary btn-sm rounded-pill px-4">
                                        <i class="bi bi-plus-lg me-1"></i> Crear primera auditoría
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    @if ($audits->hasPages())
        <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center border-top">
            <span class="text-muted small">
                Mostrando {{ $audits->firstItem() }}–{{ $audits->lastItem() }} de {{ $audits->total() }} registros
            </span>
            {{ $audits->links() }}
        </div>
    @endif
</div>

@endsection
