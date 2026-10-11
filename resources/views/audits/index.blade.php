@extends('layouts.app')

@section('title', 'Listado de Auditorías')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2 class="h3 fw-bold text-dark mb-1">
            <i class="bi bi-journal-text text-primary me-2"></i>Listado de Auditorías
        </h2>
        <p class="text-muted mb-0">Gestión, seguimiento y control de auditorías registradas en el sistema.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="{{ route('audits.create') }}" class="btn btn-primary px-3 py-2 shadow-sm rounded-3">
            <i class="bi bi-plus-lg me-1"></i> Nueva Auditoría
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-secondary">
            <i class="bi bi-table me-1"></i> Registros de Auditoría
        </span>
        <span class="badge bg-light text-dark border">
            Total: {{ $audits->total() }} registros
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 70px;"># ID</th>
                        <th style="min-width: 200px;">Título</th>
                        <th style="min-width: 250px;">Descripción</th>
                        <th style="width: 140px;">Estado</th>
                        <th style="width: 170px;">Fecha Registro</th>
                        <th class="text-end pe-4" style="width: 160px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($audits as $audit)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">
                                #{{ $audit->id }}
                            </td>
                            <td>
                                <a href="{{ route('audits.show', $audit) }}" class="text-decoration-none fw-semibold text-dark">
                                    {{ $audit->titulo }}
                                </a>
                            </td>
                            <td class="text-secondary small">
                                {{ Str::limit($audit->descripcion ?? 'Sin descripción adicional', 75, '...') }}
                            </td>
                            <td>
                                @if ($audit->estado === 'completado')
                                    <span class="badge badge-status-completado px-2 py-1 rounded-pill fw-medium">
                                        <i class="bi bi-check-circle-fill me-1"></i>Completado
                                    </span>
                                @elseif ($audit->estado === 'en_proceso')
                                    <span class="badge badge-status-en_proceso px-2 py-1 rounded-pill fw-medium">
                                        <i class="bi bi-arrow-repeat me-1"></i>En Proceso
                                    </span>
                                @else
                                    <span class="badge badge-status-pendiente px-2 py-1 rounded-pill fw-medium">
                                        <i class="bi bi-clock-history me-1"></i>Pendiente
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $audit->created_at ? $audit->created_at->format('d/m/Y H:i') : 'N/D' }}
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('audits.show', $audit) }}" class="btn btn-outline-info" title="Ver detalle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('audits.edit', $audit) }}" class="btn btn-outline-warning" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('audits.destroy', $audit) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar la auditoría \'{{ addslashes($audit->titulo) }}\'? Esta acción no se puede deshacer.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox text-muted display-4 d-block mb-3"></i>
                                    <h5 class="fw-semibold text-secondary">No hay auditorías registradas</h5>
                                    <p class="text-muted small mb-3">Comienza creando una nueva auditoría en el sistema.</p>
                                    <a href="{{ route('audits.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
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
    @if ($audits->hasPages())
        <div class="card-footer bg-white py-3 d-flex justify-content-end">
            {{ $audits->links() }}
        </div>
    @endif
</div>
@endsection
