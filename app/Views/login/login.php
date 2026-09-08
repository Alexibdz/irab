<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - IRAB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
</head>
<body class="bg-body-secondary">

<main class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
    <div class="col-12" style="max-width: 420px;">

        <div class="text-center mb-4">
            <h1 class="h3 fw-semibold mb-1">IRAB</h1>
            <p class="text-muted mb-0">Sistema de Enfermería</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h2 class="h5 mb-0">Iniciar sesión</h2>
            </div>

            <div class="card-body p-4">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/validarLogin') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username"
                               autocomplete="username" autofocus required>
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
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</main>
<script src="<?= base_url('assets/js/password.js') ?>"></script>
</body>
</html>
