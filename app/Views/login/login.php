<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - IRAB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.ico') ?>" type="image/x-icon">
</head>
<body class="bg-body-secondary pagina-login">

    <main class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
        <div class="col-12" style="max-width: 420px;">

            <div class="text-center mb-4">
                <h1 class="h3 fw-semibold mb-1">IRAB</h1>
                <h6 class="mb-1 fst-italic">Programa de Infecciones Respiratorias Agudas Bajas</h6>
            </div>

            <div class="card shadow-sm">
                <div class="card-header login-verde-degradado text-center py-3">
                    <h2 class="h5 mb-0">Iniciar sesión</h2>
                </div>

                <div class="card-body p-4">
                    <!-- el id es para capturarlo con js -->
                    <form id="form-login" action="<?= base_url('/validarLogin') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="username" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="username" name="username" autocomplete="username" autofocus required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" required>
                                <button type="button" class="btn btn-outline-secondary" id="mostrarPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn login-verde-degradado btn-login-verde w-100 py-2 fw-semibold">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <!--cartel flotante de notificaciones (Esquina superior derecha) que se activa segun es rechazado o bienvenido al sistema -->
    <div id="toast-flotante" class="position-fixed top-0 end-0 p-4" style="z-index: 1050; display: none;">
        <div id="toast-color" class="alert shadow-lg d-flex align-items-center mb-0" role="alert">
            <span id="toast-mensaje" class="fw-semibold"></span>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url('assets/js/password.js') ?>"></script>
    <script src="<?= base_url('assets/js/login.js') ?>"></script>
</body>
</html>