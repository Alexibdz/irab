<?php

namespace App\Models;

class FactoresModel extends BaseModel
{
    protected $table = 'factores';

    protected $allowedFields = ['denominacion','tipo','tipo_formulario','fecha_borrado'];
}
