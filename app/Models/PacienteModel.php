<?php
namespace App\Models;
use CodeIgniter\Model;

class PacienteModel extends Model{
    protected $table = 'pacientes';
    
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'dni', 
        'nombre', 
        'fecha_nacimiento',
        'id_tutor', 
        'id_establecimiento_habitual'
    ];

}