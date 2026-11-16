<?php

namespace App\Controllers;

class Auditoria extends BaseController
{
    // Registro de movimientos de visitas y controles. Solo Administrador.
    public function index()
    {
        if (! es_admin()) {
            return redirect()->to(base_url('panel'))
                ->with('error', 'La auditoría es exclusiva del administrador.');
        }

        $registros = db_connect()->table('auditoria a')
            ->select("a.*, CONCAT(u.nombre, ' ', u.apellido) AS usuario,
                      CONCAT(p.apellido, ', ', p.nombre) AS paciente, p.dni")
            ->join('usuarios u', 'u.id = a.id_usuario', 'left')
            ->join('pacientes p', 'p.id = a.id_paciente', 'left')
            ->orderBy('a.fecha', 'DESC')
            ->get()
            ->getResultArray();

        echo view('templates/header', ['titulo' => 'Auditoría']);
        echo view('auditoria/index', ['registros' => $registros]);
        echo view('templates/footer');
    }
}
