<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-normal mb-3">Listado de Pacientes</h2>
        
        <div class="d-flex gap-2">
            <a href="<?= base_url('visitas/crear') ?>" class="btn btn-primary fw-semibold">
                <i class="bi bi-plus-lg"></i> Nuevo Paciente
            </a>
            <a href="<?= base_url('paciente/eliminados') ?>" class="btn btn-danger fw-semibold">
                Ver Papelera
            </a>
        </div>
    </div>

    <div class="card shadow-sm border rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center align-middle tabla-datos w-100">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center align-middle">DNI</th>
                            <th class="text-center align-middle">Nombre Completo</th>
                            <th class="text-center align-middle">Fecha de Nacimiento</th>
                            <th class="text-center align-middle">Tutor / Responsable</th>
                            <th class="text-center align-middle">Teléfono</th>
                            <th class="text-center align-middle">Domicilio</th>
                            <th class="text-center align-middle">Barrio</th>
                            <th class="text-center align-middle">Establecimiento Habitual</th>
                            <th class="text-center align-middle">Área Programática</th>
                            <th class="text-center align-middle" style="width: 130px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pacientes as $paciente): ?>
                            <tr>
                                <td class="text-center align-middle"><?= esc($paciente['dni']) ?></td>
                                <td class="text-center align-middle"><?= esc($paciente['nombre']) ?></td>
                                <td class="text-center align-middle"><?= esc($paciente['fecha_nacimiento']) ?></td> 
                                <td class="text-center align-middle">
                                    <?php  
                                        $nombre_tutor = 'No asignado';
                                        foreach($tutores as $tutor) {
                                            if($tutor['id'] == $paciente['id_tutor']) {
                                                $nombre_tutor = $tutor['nombre'];
                                                break;
                                            }
                                        }
                                        echo esc($nombre_tutor);
                                    ?>
                                </td>
                                <td class="text-center align-middle">
                                    <?php
                                        $telefono_tutor = 'No registrado';
                                        foreach($tutores as $tutor) {
                                            if($tutor['id'] == $paciente['id_tutor']) {
                                                $telefono_tutor = !empty($tutor['telefono']) ? $tutor['telefono'] : 'No registrado';
                                                break;
                                            }
                                        } 
                                        echo esc($telefono_tutor);
                                    ?>
                                </td>
                                <td class="text-center align-middle"><?= esc($paciente['domicilio']) ?></td>
                                <td class="text-center align-middle"><?= esc($paciente['barrio']) ?></td>
                                <td class="text-center align-middle">
                                    <?php  
                                        $nombre_est_habitual = '-';
                                        foreach($establecimientos as $establecimiento) {
                                            if($establecimiento['id'] == $paciente['id_establecimiento_habitual']) {
                                                $nombre_est_habitual = $establecimiento['nombre'];
                                                break;
                                            }
                                        }
                                        echo esc($nombre_est_habitual);
                                    ?>
                                </td>
                                <td class="text-center align-middle">
                                    <?php  
                                        $nombre_area = '-';
                                        foreach($establecimientos as $establecimiento) {
                                            if($establecimiento['id'] == $paciente['id_area_programatica']) {
                                                $nombre_area = $establecimiento['nombre'];
                                                break;
                                            }
                                        }
                                        echo esc($nombre_area);
                                    ?>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-inline-flex gap-1 justify-content-center">
                                        <a href="<?= base_url('paciente/editar/' . $paciente['id']) ?>" 
                                           class="btn btn-warning btn-sm text-dark" 
                                           title="Editar paciente">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('paciente/borrar/' . $paciente['id']) ?>" 
                                           class="btn btn-danger btn-sm text-white" 
                                           onclick="return confirm('¿Seguro que deseas borrar este paciente?');" 
                                           title="Borrar paciente">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>