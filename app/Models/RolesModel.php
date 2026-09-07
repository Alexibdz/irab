<?php

namespace App\Models;

class RolesModel extends BaseModel
{
    protected $table = 'roles';

    protected $allowedFields = ['nombre','fecha_borrado'];
}
