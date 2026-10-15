@extends('layouts.app')

@section('title', 'Tipos de Auditoría')

@section('content')

{{-- cabecera --}}
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h1 class="h3 fw-bold text-dark mb-1">
            <i class="bi bi-bookmark-check text-primary me-2"></i>Tipos de Auditoría (Normas)
        </h1>
        <p class="text-muted mb-0 small">
            Catálogo de normas y estándares para clasificar las auditorías del sistema.
        </p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="{{ route('audit-types.create') }}" class="btn btn-primary px-4 shadow-sm rounded-3">
            <i class="bi bi-plus-lg me-1"></i> Nueva Norma
        </a>
    </div>
</div>

{{-- tabla de tipos --}}
<div class="card shadow-sm border-0 rounded-4 overflow-hidden">

    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-secondary d-flex align-items-center gap-2">
            <i class="bi bi-table text-primary"></i> Normas Registradas
        </span>
        <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
            <i class="bi bi-database me-1 text-muted"></i>
            Total: <strong>{{ $tipos->total() }}</strong> registros
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 70px;"># ID</th>
                        <th style="min-width: 260px;">NOMBRE DE LA NORMA</th>
                        <th style="min-width: 320px;">DESCRIPCIÓN / QUÉ EVALÚA</th>
                        <th style="width: 170px;">FECHA REGISTRO</th>
                        <th class="text-end pe-4" style="width: 170px;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tipos as $tipo)
                        <tr>
                            {{-- id --}}
                            <td class="ps-4">
                                <span class="badge bg-light text-secondary border fw-semibold">#{{ $tipo->id }}</span>
                            </td>

                            {{-- nombre norma --}}
                            <td>
                                <a href="{{ route('audit-types.show', $tipo) }}" class="fw-semibold text-dark text-decoration-none">
                                    {{ $tipo->nombre_norma }}
                                </a>
                            </td>

                            {{-- descripcion --}}
                            <td>
                                <span class="text-muted small text-truncate d-inline-block" style="max-width: 420px;" title="{{ $tipo->descripcion }}">
                                    {{ $tipo->descripcion }}
                                </span>
                            </td>

                            {{-- fecha --}}
                            <td>
                                <span class="text-muted small">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $tipo->created_at ? $tipo->created_at->format('d/m/Y') : '—' }}
                                </span>
                            </td>

                            {{-- botones de accion --}}
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('audit-types.show', $tipo) }}" class="btn btn-outline-secondary" title="Ver detalle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('audit-types.edit', $tipo) }}" class="btn btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-outline-danger"
                                            title="Eliminar"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-action="{{ route('audit-types.destroy', $tipo) }}"
                                            data-title="{{ $tipo->nombre_norma }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    <p class="mb-2">No hay tipos de auditoria registrados</p>
                                    <a href="{{ route('audit-types.create') }}" class="btn btn-primary btn-sm px-3 rounded-pill">
                                        <i class="bi bi-plus-lg me-1"></i> Registrar la primera
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- paginacion --}}
    @if ($tipos->hasPages())
        <div class="card-footer bg-white py-3 border-top d-flex justify-content-between align-items-center">
            <span class="small text-muted">
                Mostrando {{ $tipos->firstItem() }} - {{ $tipos->lastItem() }} de {{ $tipos->total() }} registros
            </span>
            <div>
                {{ $tipos->links() }}
            </div>
        </div>
    @endif
</div>

@endsection
