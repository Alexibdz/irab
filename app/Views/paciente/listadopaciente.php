<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Pacientes</title>
    <!-- esto hay q unificarlo despues -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <div class="container mt-5">
        <h2 class="mb-4">Listado de Pacientes Registrados</h2>
        
        <!-- para agregar a agregar otro paciente -->
        <a href="<?= base_url('paciente/nuevo') ?>" class="btn btn-primary mb-3">
            + Nuevo Paciente
        </a>
        <a href="<?= base_url('paciente/eliminados') ?>" class="btn btn-danger mb-3">Ver Pacientes Eliminados</a>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th>Nombre Completo</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Tutor</th>
                            <th>Establecimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- recorro los datos -->
                        <?php foreach ($pacientes as $paciente): ?>
                            <tr>
                                <td><?= $paciente['dni'] ?></td>
                                <td><?= $paciente['nombre'] ?></td>
                                <td><?= $paciente['fecha_nacimiento'] ?></td>
                                <td>
                                    <?php
                                        foreach($tutores as $tutor){
                                            if($tutor['id'] == $paciente['id_tutor']){
                                                echo $tutor['nombre'];
                                                break; //lo cortamos para q no siga iterando
                                            }
                                        } 
                                    
                                    ?>
                                </td>
                                <td>
                                    <?php  
                                        foreach($establecimientos as $establecimiento) {
                                            if($establecimiento['id'] == $paciente['id_establecimiento_habitual']) {
                                                echo $establecimiento['nombre'];
                                                break;
                                            }
                                        }
                                    ?>
</td>
                                <td>
                                    <a href="<?= base_url('paciente/editar/'.$paciente['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="<?= base_url('paciente/borrar/'.$paciente['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas borrar este paciente?');">Borrar</a>
                                </td>
                            </tr>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>