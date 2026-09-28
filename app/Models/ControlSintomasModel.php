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
        // no colocamos $primaryKey = 'id' ya que esta tabla no tiene una columna 'id' simple.
}