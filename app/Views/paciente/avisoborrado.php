<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Paciente Eliminado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 text-center">
        <div class="alert alert-success shadow-sm" role="alert">
            <h4 class="alert-heading">¡Acción exitosa!</h4>
            <p>El paciente ha sido eliminado del registro activo correctamente.</p>
            <hr>
            <a href="<?= base_url('paciente') ?>" class="btn btn-primary">Volver al Listado</a>
        </div>
    </div>
</body>
</html>