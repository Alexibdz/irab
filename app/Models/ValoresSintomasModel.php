<?php

namespace App\Models;

class ValoresSintomasModel extends BaseModel
{
    protected $table = 'valores_sintomas';

    protected $allowedFields = ['id_sintoma','valor_min','valor_max','valor_texto','puntos','fecha_borrado'];
}
