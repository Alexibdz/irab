<div class="container-fluid py-4">
    <!-- 1. Encabezado de la página: Título sin negrita y botones superiores -->
    <div class="mb-4">
        <h2 class="fw-normal mb-3">Listado de Síntomas</h2>
        
        <div class="d-flex gap-2">
            <a href="<?= base_url('configuracion/sintomas/nuevo') ?>" class="btn btn-primary fw-semibold">
                <i class="bi bi-plus-lg"></i> Nuevo Síntoma
            </a>
            <a href="<?= base_url('configuracion/sintomas/eliminados') ?>" class="btn btn-danger fw-semibold">
                Ver Síntomas Eliminados
            </a>
        </div>
    </div>

    <!-- 2. Tarjeta contenedora blanca con bordes y sombra suave -->
    <div class="card shadow-sm border rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center align-middle tabla-datos w-100">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center align-middle">Nombre del Síntoma</th>
                            <th class="text-center align-middle">Tipo de Formulario</th>
                            <th class="text-center align-middle" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sintomas as $sintoma): ?>
                            <tr>
                                <td class="text-center align-middle"><?= esc($sintoma['nombre_sintoma']) ?></td>
                                <td class="text-center align-middle"><?= esc($sintoma['tipo_formulario']) ?></td>
                                <td class="text-center align-middle">
                                    <div class="d-inline-flex gap-1 justify-content-center">
                                        <!-- 1. Ver: Celeste con ícono BLANCO -->
                                        <a href="<?= base_url('configuracion/sintomas/ver/' . $sintoma['id']) ?>" 
                                           class="btn btn-info btn-sm text-white" 
                                           title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- 2. Valores: Azul con ícono y texto BLANCO -->
                                        <a href="<?= base_url('configuracion/sintomas/valores/' . $sintoma['id']) ?>" 
                                           class="btn btn-primary btn-sm text-white" 
                                           title="Valores del síntoma">
                                            <i class="bi bi-bar-chart-line"></i> Valores
                                        </a>

                                        <!-- 3. Editar: Anaranjado/Amarillo con ícono NEGRO -->
                                        <a href="<?= base_url('configuracion/sintomas/editar/' . $sintoma['id']) ?>" 
                                           class="btn btn-warning btn-sm text-dark" 
                                           title="Editar síntoma">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- 4. Eliminar: Rojo con ícono BLANCO -->
                                        <a href="<?= base_url('configuracion/sintomas/eliminar/' . $sintoma['id']) ?>" 
                                           class="btn btn-danger btn-sm text-white" 
                                           onclick="return confirm('¿Seguro que deseas borrar este síntoma?');" 
                                           title="Eliminar síntoma">
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