<?php

namespace App\Models;

use CodeIgniter\Model;

class ControlModel extends Model
{
    protected $table      = 'controles';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_visita', 'fecha_hora', 'score_total',
        'estado_gravedad', 'medicacion', 'observaciones'
    ];
}