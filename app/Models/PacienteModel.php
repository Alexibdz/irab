<?php

namespace App\Models;

class PacienteModel extends BaseModel
{
    protected $table = 'pacientes';

    protected $allowedFields = [
        'dni',
        'nombre',
        'fecha_nacimiento',
        'id_tutor',
        'domicilio',
        'barrio',
        'id_area_programatica',
        'id_establecimiento_habitual',
        'fecha_borrado'
    ];
}
