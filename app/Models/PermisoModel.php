<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisoModel extends Model
{
    protected $table = 'permisos';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_rol',
        'modulo',
        'puede_ver',
        'puede_crear',
        'puede_editar',
        'puede_eliminar'
    ];
}