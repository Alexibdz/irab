<?php

namespace App\Models;

use CodeIgniter\Model;

class EstablecimientosModel extends Model
{
    protected $table = 'establecimientos_salud';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nombre','cuartel','tipo', 'fecha_registro','fecha_edicion','fecha_borrado'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_registro';
    protected $updatedField  = 'fecha_edicion';
    protected $deletedField   = 'fecha_borrado';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}