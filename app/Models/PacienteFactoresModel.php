<?php

namespace App\Models;

class PacienteFactoresModel extends BaseModel
{
    protected $table = 'paciente_factores';

    protected $allowedFields = [
        'id_visita',
        'id_paciente',
        'id_factor',
        'valor_registrado',
        'fecha_borrado'
    ];
}