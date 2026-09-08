<?php

namespace App\Models;

class EstablecimientosModel extends BaseModel
{
    protected $table = 'establecimientos_salud';

    protected $allowedFields = ['nombre','cuartel','tipo','fecha_borrado'];
}
