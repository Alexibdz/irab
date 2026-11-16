<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicacionModel extends BaseModel
{
    protected $table         = 'medicaciones';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['nombre'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_registro';
    protected $updatedField  = 'fecha_edicion';
    protected $useSoftDeletes = true;
    protected $deletedField  = 'fecha_borrado';

    public function obtenerOCrearPorNombre(string $nombre): int|false
    {
        $nombre = trim($nombre);
        $longitud = mb_strlen($nombre);

        if ($longitud < 2 || $longitud > 100) {
            return false;
        }

        $existente = $this->where('nombre', $nombre)->first();
        if ($existente) {
            return (int) $existente['id'];
        }

        if ($this->withDeleted()->where('nombre', $nombre)->first()) {
            return false;
        }

        $id = $this->insert(['nombre' => $nombre], true);

        return $id ? (int) $id : false;
    }
}