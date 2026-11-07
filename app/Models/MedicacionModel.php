<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicacionModel extends BaseModel
{
    protected $table         = 'medicaciones';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['nombre'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_registro';
    protected $updatedField  = 'fecha_edicion';
    protected $useSoftDeletes = true;
    protected $deletedField  = 'fecha_borrado';
}