<?php

namespace App\Models;

use CodeIgniter\Model;

// Base de models: los hijos definen $table y $allowedFields ('fecha_borrado' incluido)
abstract class BaseModel extends Model
{
    // Borrado logico
    protected $useSoftDeletes = true;

    // Fechas automaticas
    protected $useTimestamps = true;

    // Columnas propias
    protected $createdField = 'fecha_registro';
    protected $updatedField = 'fecha_edicion';
    protected $deletedField = 'fecha_borrado';
}
