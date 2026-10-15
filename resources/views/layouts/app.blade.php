<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Sistema de Auditorías') — Laravel CRUD</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* ─── Base ─────────────────────────────────────────── */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ─── Navbar ────────────────────────────────────────── */
        .navbar-custom {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
            font-size: 1.1rem;
        }
        .navbar-brand .brand-icon {
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .nav-link {
            transition: color 0.2s ease;
        }

        /* ─── Cards ─────────────────────────────────────────── */
        .card {
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
            border-radius: 0.875rem;
            transition: box-shadow 0.2s ease;
        }
        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 600;
            border-radius: 0.875rem 0.875rem 0 0 !important;
        }

        /* ─── Tabla ──────────────────────────────────────────── */
        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            font-weight: 700;
            border-bottom: 2px solid #e2e8f0;
            padding-top: 0.875rem;
            padding-bottom: 0.875rem;
        }
        .table tbody tr {
            transition: background-color 0.15s ease;
        }
        .table-hover tbody tr:hover {
            background-color: #f8fafc;
        }

        /* ─── Badges de estado ────────────────────────────────── */
        .badge-status {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35em 0.75em;
            border-radius: 999px;
            border: 1px solid transparent;
            letter-spacing: 0.01em;
        }
        .badge-status-pendiente {
            background-color: #fef3c7;
            color: #92400e;
            border-color: #fde68a;
        }
        .badge-status-en_proceso {
            background-color: #dbeafe;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }
        .badge-status-completado {
            background-color: #dcfce7;
            color: #15803d;
            border-color: #bbf7d0;
        }

        /* ─── Alertas flash ──────────────────────────────────── */
        .alert-flash {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            animation: slideInDown 0.35s ease both;
        }
        .alert-flash .border-indicator {
            width: 4px;
            border-radius: 4px;
            align-self: stretch;
            flex-shrink: 0;
        }
        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ─── Formularios ────────────────────────────────────── */
        .form-control:focus,
        .form-select:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.18);
        }
        .form-control.is-invalid:focus,
        .form-select.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.18);
        }
        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
        }
        .char-counter {
            font-size: 0.75rem;
            color: #94a3b8;
            transition: color 0.2s;
        }
        .char-counter.warn  { color: #f59e0b; }
        .char-counter.error { color: #ef4444; font-weight: 600; }

        /* ─── Botones ────────────────────────────────────────── */
        .btn {
            font-weight: 500;
            letter-spacing: 0.01em;
            transition: all 0.2s ease;
        }
        .btn:active { transform: scale(0.97); }

        /* ─── Paginación ─────────────────────────────────────── */
        .pagination .page-link {
            border-radius: 0.5rem !important;
            margin: 0 2px;
            font-size: 0.875rem;
        }

        /* ─── Footer ─────────────────────────────────────────── */
        footer {
            margin-top: auto;
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
        }

        /* ─── Modal confirmación ─────────────────────────────── */
        #deleteModal .modal-content {
            border-radius: 0.875rem;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.18);
        }
        #deleteModal .modal-header {
            background: #fef2f2;
            border-bottom: 1px solid #fecaca;
            border-radius: 0.875rem 0.875rem 0 0;
        }
    </style>
</head>
<body>

    <!-- ══════════════ NAVBAR ══════════════ -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('audits.index') }}">
                <i class="bi bi-shield-check brand-icon fs-4"></i>
                <span>Gestión de Auditorías</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('audits.*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('audits.index') }}">
                            <i class="bi bi-list-ul me-1"></i> Auditorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('audit-types.*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('audit-types.index') }}">
                            <i class="bi bi-bookmark-check me-1"></i> Tipos de Auditoría
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm px-3 rounded-pill d-flex align-items-center gap-1 shadow-sm"
                           href="{{ route('audits.create') }}">
                            <i class="bi bi-plus-circle"></i>
                            <span>Nueva Auditoría</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ══════════════ CONTENIDO PRINCIPAL ══════════════ -->
    <main class="container py-4 flex-grow-1">

        <!-- ── Alerta de ÉXITO ── -->
        @if (session('success'))
            <div class="alert alert-flash alert-success alert-dismissible fade show d-flex align-items-center gap-3 mb-4"
                 role="alert" id="flashAlert">
                <div class="border-indicator bg-success"></div>
                <i class="bi bi-check-circle-fill fs-5 text-success flex-shrink-0"></i>
                <div class="flex-grow-1">
                    <strong class="d-block">¡Operación exitosa!</strong>
                    <span class="small">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <!-- ── Alerta de ADVERTENCIA (ej: eliminación) ── -->
        @if (session('warning'))
            <div class="alert alert-flash alert-warning alert-dismissible fade show d-flex align-items-center gap-3 mb-4"
                 role="alert" id="flashAlert">
                <div class="border-indicator bg-warning"></div>
                <i class="bi bi-exclamation-triangle-fill fs-5 text-warning flex-shrink-0"></i>
                <div class="flex-grow-1">
                    <strong class="d-block">Registro eliminado</strong>
                    <span class="small">{{ session('warning') }}</span>
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <!-- ── Alerta de ERROR ── -->
        @if (session('error'))
            <div class="alert alert-flash alert-danger alert-dismissible fade show d-flex align-items-center gap-3 mb-4"
                 role="alert" id="flashAlert">
                <div class="border-indicator bg-danger"></div>
                <i class="bi bi-x-circle-fill fs-5 text-danger flex-shrink-0"></i>
                <div class="flex-grow-1">
                    <strong class="d-block">¡Error!</strong>
                    <span class="small">{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- ══════════════ MODAL — Confirmar Eliminación ══════════════ -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-trash3-fill text-danger fs-5"></i>
                        </div>
                        <h5 class="modal-title fw-bold text-danger mb-0" id="deleteModalLabel">
                            Confirmar Eliminación
                        </h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <p class="text-secondary mb-1">¿Estás seguro de eliminar la auditoría:</p>
                    <p class="fw-bold text-dark mb-3" id="deleteAuditTitle">—</p>
                    <div class="alert alert-danger py-2 px-3 small rounded-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Esta acción es <strong>permanente</strong> e irreversible.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x me-1"></i> Cancelar
                    </button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4 shadow-sm">
                            <i class="bi bi-trash3 me-1"></i> Sí, eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════════ FOOTER ══════════════ -->
    <footer class="py-3 text-center text-muted small">
        <div class="container">
            <p class="mb-0">
                &copy; {{ date('Y') }} <strong>Proyecto Universitario</strong>
                &bull; Sistema de Auditorías con Laravel &amp; MySQL
                &bull; Ingeniería de Sistemas
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    <script>
        // ── Auto-dismiss alertas flash tras 5 segundos ──────────────
        document.addEventListener('DOMContentLoaded', function () {
            const flashAlert = document.getElementById('flashAlert');
            if (flashAlert) {
                setTimeout(function () {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(flashAlert);
                    bsAlert.close();
                }, 5000);
            }

            // ── Modal de Confirmación de Borrado ───────────────────
            const deleteModal  = document.getElementById('deleteModal');
            const deleteForm   = document.getElementById('deleteForm');
            const titleDisplay = document.getElementById('deleteAuditTitle');

            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const btn    = event.relatedTarget;
                    const action = btn.getAttribute('data-action');
                    const title  = btn.getAttribute('data-title');

                    deleteForm.action   = action;
                    titleDisplay.textContent = '"' + title + '"';
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
