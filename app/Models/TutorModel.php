<?php
namespace App\Models;
use CodeIgniter\Model;

class TutorModel extends Model {
    protected $table = 'tutores';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'dni', 
        'nombre',
        'telefono', 
        'fecha_borrado'
    ];

    protected $useTimestamps   = true;
    protected $useSoftDeletes  = true;

    protected $createdField    = 'fecha_registro';
    protected $updatedField    = 'fecha_edicion';
    protected $deletedField    = 'fecha_borrado';
}