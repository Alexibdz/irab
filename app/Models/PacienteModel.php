<?php
namespace App\Models;
use CodeIgniter\Model;

class PacienteModel extends Model {
    protected $table = 'pacientes';
    
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'dni', 
        'nombre', 
        'fecha_nacimiento',
        'id_tutor', 
        'id_establecimiento_habitual',
        'fecha_borrado'
    ];

    // para usar elborrado lógico
    protected $useTimestamps   = true;
    protected $useSoftDeletes  = true;

    protected $createdField    = 'fecha_registro';
    protected $updatedField    = 'fecha_edicion';
    protected $deletedField    = 'fecha_borrado';
}