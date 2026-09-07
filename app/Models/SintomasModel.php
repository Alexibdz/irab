<?php

namespace App\Models;

class SintomasModel extends BaseModel
{
    protected $table = 'sintomas';

    protected $allowedFields = ['nombre_sintoma','tipo_formulario','fecha_borrado'];
}
