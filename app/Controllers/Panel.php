<?php

namespace App\Controllers;

use App\Models\VisitaModel;
use App\Models\PacienteModel;
use App\Models\TutorModel;
use App\Models\ControlModel;

class Panel extends BaseController
{
    public function index()
    {
        $visitaModel   = new VisitaModel();
        $pacienteModel = new PacienteModel();
        $tutorModel    = new TutorModel();
        $controlModel  = new ControlModel();

        // Visitas abiertas con paciente y establecimiento
        $abiertas = $visitaModel->builder()
            ->select('visitas.id, visitas.fecha_ingreso, visitas.diagnostico,
                      pacientes.nombre AS paciente, pacientes.fecha_nacimiento,
                      establecimientos_salud.nombre AS establecimiento')
            ->join('pacientes', 'pacientes.id = visitas.id_paciente', 'left')
            ->join('establecimientos_salud', 'establecimientos_salud.id = visitas.id_establecimiento', 'left')
            ->where('visitas.fecha_borrado IS NULL')
            ->where('visitas.fecha_alta IS NULL')
            ->orderBy('visitas.fecha_ingreso', 'ASC')
            ->get()
            ->getResultArray();

        // Ultimo control de cada visita abierta
        $ultimos = [];
        if (!empty($abiertas)) {
            $controles = $controlModel->builder()
                ->select('id_visita, fecha_hora, score_total, estado_gravedad')
                ->where('fecha_borrado IS NULL')
                ->whereIn('id_visita', array_column($abiertas, 'id'))
                ->orderBy('fecha_hora', 'ASC')
                ->get()
                ->getResultArray();

            foreach ($controles as $control) {
                $ultimos[$control['id_visita']] = $control;
            }
        }

        foreach ($abiertas as &$visita) {
            $visita['ultimo_control'] = $ultimos[$visita['id']] ?? null;
        }
        unset($visita);

        $datos = [
            'titulo'    => 'Panel',
            'abiertas'  => $abiertas,
            'cerradas'  => $visitaModel->where('fecha_alta IS NOT NULL')->countAllResults(),
            'pacientes' => $pacienteModel->countAllResults(),
            'tutores'   => $tutorModel->countAllResults(),
            'controlesHoy' => $controlModel->where('DATE(fecha_hora)', date('Y-m-d'))->countAllResults()
        ];

        echo view('templates/header', $datos);
        echo view('panel/inicio', $datos);
        echo view('templates/footer');
    }
}
