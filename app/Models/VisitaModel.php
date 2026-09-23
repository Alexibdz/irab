<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitaModel extends Model
{
    protected $table      = 'visitas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_paciente',
        'id_usuario',
        'id_establecimiento',
        'fecha_ingreso',
        'diagnostico',
        'estado_derivacion',
        'id_turno_protegido_lugar',
        'turno_protegido_fecha',
        'medicacion_egreso',
        'fecha_alta',
        'observaciones_finales',
        'fecha_borrado'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_registro';
    protected $updatedField  = 'fecha_edicion';
    protected $deletedField  = 'fecha_borrado';

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