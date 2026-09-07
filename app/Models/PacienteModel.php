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
        'id_establecimiento_habitual',
        'fecha_borrado'
    ];
}
