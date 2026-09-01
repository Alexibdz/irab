<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de nuevo paciente</title>
    <!-- pongo aca  Bootstrap para probarlo despues hay que sacarlo de aca -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h4 mb-0">Registrar Nuevo Paciente</h2>
                    </div>
                    
                    <div class="card-body">
                        <form action="<?= base_url('paciente/insertar') ?>" method="POST">
                            <!-- Genera un campo oculto con una clave única de seguridad, esto porque maxi agrego eso en seguridad y me tiraba error-->
                             <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" required>
                            </div>

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                            </div>

                            <!-- 
                             
                                Este campo es un 'input' numérico temporalmente. 
                                Cuando los módulos de Tutores estén listos, lo cambip por un 
                                <select class="form-select"> que muestre los nombres, eso lo hace otra persona
                            -->
                            <div class="mb-3">
                                <label for="id_tutor" class="form-label">ID del Tutor Responsable</label>
                                <input type="number" class="form-control" id="id_tutor" name="id_tutor" required>
                            </div>

                            <!-- 
                                
                                Al igual que el tutor, este campo numérico se reemplazará más adelante 
                                por un menú desplegable conectado a la tabla de Establecimientos.
                            -->
                            <div class="mb-3">
                                <label for="id_establecimiento_habitual" class="form-label">ID del Establecimiento Habitual</label>
                                <input type="number" class="form-control" id="id_establecimiento_habitual" name="id_establecimiento_habitual" required>
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('paciente') ?>" class="btn btn-secondary">Cancelar</a>                                <button type="submit" class="btn btn-primary">Guardar Paciente</button>
                            </div>
                            
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>