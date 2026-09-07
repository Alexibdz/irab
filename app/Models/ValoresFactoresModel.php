<?php

namespace App\Models;

class ValoresFactoresModel extends BaseModel
{
    protected $table = 'valores_factores';

    protected $allowedFields = ['id_factor','valor','fecha_borrado'];
}
