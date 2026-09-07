<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Base de models. Los hijos solo definen $table y $allowedFields.
 *
 *'fecha_borrado' tiene que estar en el $allowedFields de cada hijo porque
 * recuperar() la pasa a mano en un update() y allowedFields filtra ese update.
 * Si la sacan, el array queda vacio y explota con DataException "There is no
 * data to update".
 */
abstract class BaseModel extends Model
{
    // Borrado logico en lugar de DELETE fisico
    protected $useSoftDeletes = true;

    // Completa las fechas de alta y modificacion automaticamente
    protected $useTimestamps = true;

    // Nombres de columnas propios de este proyecto
    protected $createdField = 'fecha_registro';
    protected $updatedField = 'fecha_edicion';
    protected $deletedField = 'fecha_borrado';
}
