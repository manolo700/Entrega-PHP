<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — Sistema de Auditorías &amp; Accounting</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #334155;
            padding: 2rem 1rem;
        }
        .login-card {
            background: #ffffff;
            border-radius: 1.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .login-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #ffffff;
            padding: 2.25rem 2rem 1.75rem;
            text-align: center;
            position: relative;
        }
        .brand-badge {
            width: 68px;
            height: 68px;
            border-radius: 1rem;
            background: linear-gradient(135deg, #0284c7, #38bdf8);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(2, 132, 199, 0.35);
            margin-bottom: 1rem;
        }
        .form-control:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 0.25rem rgba(2, 132, 199, 0.15);
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border: none;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
        }
        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(2, 132, 199, 0.3);
        }
        .btn-primary-custom:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Header -->
        <div class="login-header">
            <div class="brand-badge">
                <i class="bi bi-shield-check text-white fs-1"></i>
            </div>
            <h4 class="fw-bold mb-1">Módulo Accounting</h4>
            <p class="text-white-50 small mb-0">Autenticación &amp; Control de Acceso</p>
        </div>

        <!-- Body -->
        <div class="p-4 p-md-4">

            <!-- Mensajes flash -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show small d-flex align-items-center gap-2 mb-3" role="alert">
                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show small d-flex align-items-center gap-2 mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-5"></i>
                    <div>{{ session('warning') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show small d-flex align-items-center gap-2 mb-3" role="alert">
                    <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show small mb-3" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-exclamation-octagon-fill me-1"></i> Errores de validación:</div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Formulario de Login -->
            <form action="{{ route('login.post') }}" method="POST" novalidate>
                @csrf

                <!-- Correo electrónico -->
                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold text-secondary">
                        <i class="bi bi-envelope me-1"></i> Correo Electrónico
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0">
                            <i class="bi bi-at"></i>
                        </span>
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                               placeholder="usuario@auditorias.com"
                               value="{{ old('email') }}"
                               required
                               autofocus>
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="mb-3">
                    <label for="password" class="form-label small fw-semibold text-secondary">
                        <i class="bi bi-key me-1"></i> Contraseña
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control border-start-0 border-end-0 px-0 @error('password') is-invalid @enderror"
                               placeholder="••••••••"
                               required>
                        <button class="btn btn-light border border-start-0 text-muted" type="button" id="togglePasswordBtn">
                            <i class="bi bi-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Recordarme -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small text-muted" for="remember">
                            Recordar mi sesión
                        </label>
                    </div>
                </div>

                <!-- Botón de acceso -->
                <button type="submit" class="btn btn-primary-custom text-white w-100 shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Ingresar al Sistema
                </button>
            </form>

        </div>

        <!-- Footer -->
        <div class="bg-light px-4 py-3 border-top text-center small text-muted">
            Sistema de Auditorías &amp; Control de Permisos &bull; Laravel 12
        </div>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        toggleBtn.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    </script>
</body>
</html>

