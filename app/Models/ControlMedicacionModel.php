<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class ControlMedicacionModel extends BaseModel
{
    protected $table         = 'control_medicaciones';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['id_control', 'id_medicacion', 'dosis'];
 
    protected $useTimestamps = true;
    protected $createdField  = 'fecha_registro';
    protected $updatedField  = 'fecha_edicion';
    protected $useSoftDeletes = true;
    protected $deletedField  = 'fecha_borrado';
}