<?php

namespace App\Models;

class UsuariosModel extends BaseModel
{
    protected $table = 'usuarios';

    protected $allowedFields = ['nombre','username','password','id_rol','id_establecimiento_asignado','fecha_borrado'];
}
