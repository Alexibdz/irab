<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h2 class="h4 mb-0">Editar Paciente</h2>
                    </div>
                    
                    <div class="card-body">
                        <form action="<?= base_url('paciente/actualizar') ?>" method="POST">
                            
                            <?= csrf_field() ?>
                            
                            <!-- Campo oculto obligatorio para que el controlador identifique al paciente -->
                            <input type="hidden" name="id" value="<?= $paciente['id'] ?>">

                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <!--el value va a ser lo que coincida para editar -->
                                <input type="text" class="form-control" id="dni" name="dni" value="<?= $paciente['dni'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $paciente['nombre'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= $paciente['fecha_nacimiento'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="id_tutor" class="form-label">ID del Tutor Responsable</label>
                                <input type="number" class="form-control" id="id_tutor" name="id_tutor" value="<?= $paciente['id_tutor'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="id_establecimiento_habitual" class="form-label">ID del Establecimiento Habitual</label>
                                <input type="number" class="form-control" id="id_establecimiento_habitual" name="id_establecimiento_habitual" value="<?= $paciente['id_establecimiento_habitual'] ?>" required>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="<?= base_url('paciente') ?>" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-warning">Actualizar Datos</button>
                            </div>
                            
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>