<?php

namespace App\Models;

class TutorModel extends BaseModel
{
    protected $table = 'tutores';

    protected $allowedFields = [
        'dni',
        'nombre',
        'apellido',
        'telefono',
        'fecha_borrado'
    ];
}
