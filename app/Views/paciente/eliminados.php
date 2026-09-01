<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pacientes Eliminados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4 text-danger">Pacientes Eliminados (Inactivos)</h2>
        <a href="<?= base_url('paciente') ?>" class="btn btn-secondary mb-3">Volver a Pacientes Activos</a>
        
        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>DNI</th>
                    <th>Nombre Completo</th>
                    <th>Fecha de Borrado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pacientes as $paciente): ?>
                    <tr>
                        <td><?= $paciente['dni'] ?></td>
                        <td><?= $paciente['nombre'] ?></td>
                        <td><?= $paciente['fecha_borrado'] ?></td>
                        <td>
                            <a href="<?= base_url('paciente/recuperar/'.$paciente['id']) ?>" class="btn btn-success btn-sm">Recuperar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>