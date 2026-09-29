<?php

namespace App\Models;

class ControlSintomasModel extends BaseModel
{
    protected $table = 'control_sintomas';

    protected $allowedFields = [
        'id_control',
        'id_sintoma',
        'valor_registrado',
        'fecha_borrado' 
    ];
        // Sin $primaryKey: la tabla no tiene columna 'id'
}