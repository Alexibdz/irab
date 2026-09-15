<div class="container-fluid mt-5">

    <h2 class="mb-4">Listado de Visitas</h2>

    <!-- Botones -->
    <div class="mb-3">

        <a href="<?= base_url('visitas/crear') ?>"
           class="btn btn-primary">
            + Nueva Visita
        </a>

        <a href="<?= base_url('visitas/eliminados') ?>"
           class="btn btn-danger">
            Ver Visitas Eliminadas
        </a>

    </div>


    <!-- Tabla -->
    <div class="card shadow-sm">
        <div class="card-body">

            <table id="tablaVisitas"
                   class="table table-striped table-hover table-bordered">

                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Usuario</th>
                        <th>Establecimiento</th>
                        <th>Fecha de ingreso</th>
                        <th>Diagnóstico</th>
                        <th>Estado de Derivación</th>
                        <th>Turno protegido</th>
                        <th>Medicación al Egreso</th>
                        <th>Fecha de alta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($visitas as $visita): ?>
                        <tr>

                            <td>
                                <?php foreach ($pacientes as $paciente) {
                                    if($visita['id_paciente'] == $paciente['id']) {
                                        echo $paciente['nombre'];
                                        break;
                                    }

                                } ?>
                                
                            </td>

                            <td>
                                <?php foreach ($usuarios as $usuario) {
                                    if($visita['id_usuario'] == $usuario['id']) {
                                        echo $usuario['nombre'];
                                        break;
                                    }
                                }?>
                                
                            </td>

                            <td>
                                <?php foreach ($establecimientos as $establecimiento) {
                                    if($visita['id_establecimiento'] == $establecimiento['id']) {
                                        echo $establecimiento['nombre'];
                                        break;
                                    }
                                }?>
                                
                            </td>

                    

                            <td>
                                <?= esc($visita['fecha_ingreso']) ?>
                            </td>

                            <td>
                                <?= esc($visita['diagnostico']) ?>
                            </td>

                            <td>
                                <?= esc($visita['estado_derivacion']) ?>
                            </td>

                            <td>
                                <?= esc($visita['turno_protegido_fecha'] ?? '') ?>
                            </td>

                            <td>
                                <?= esc($visita['medicacion_egreso'] ?? '') ?>
                            </td>

                            <td>
                                <?= esc($visita['fecha_alta'] ?? '') ?>
                            </td>

                            <td class="text-center">

                                <a href="<?= base_url('visitas/editar/' . $visita['id']) ?>"
                                   class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <a href="<?= base_url('visitas/borrar/' . $visita['id']) ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Seguro que deseas eliminar esta visita?');">
                                    Borrar
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>
    </div>

</div>


<script>
$(document).ready(function () {

    $('#tablaVisitas').DataTable({

        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "Ningún dato disponible en esta tabla",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            search: "Buscar:",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        }

    });

});
</script>