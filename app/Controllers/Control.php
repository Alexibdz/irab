<?php

namespace App\Controllers;

use App\Models\ControlModel;
use App\Models\ControlSintomasModel;
use App\Models\ValoresSintomasModel;
use App\Models\VisitaModel;
use App\Models\PacienteModel;

class Control extends BaseController
{
    protected $controlModel;
    protected $controlSintomasModel;
    protected $valoresSintomasModel;
    protected $visitaModel;
    protected $pacienteModel;

    public function __construct()
    {
        $this->controlModel         = new ControlModel();
        $this->controlSintomasModel = new ControlSintomasModel();
        $this->valoresSintomasModel = new ValoresSintomasModel();
        $this->visitaModel          = new VisitaModel();
        $this->pacienteModel        = new PacienteModel();
    }

    public function crear($id_visita)
    {
        $visita = $this->visitaModel->find($id_visita);
        if (!$visita) return redirect()->to(base_url('visitas'))->with('error', 'La visita no existe.');

        $paciente = $this->pacienteModel->find($visita['id_paciente']);

        // Edad exacta para la vista
        $fecha_nac = new \DateTime($paciente['fecha_nacimiento']);
        $hoy = new \DateTime(); 
        $meses_edad = ($fecha_nac->diff($hoy)->y * 12) + $fecha_nac->diff($hoy)->m;
        // TAL menores de 2 anios, WDF mayores
        $tipo_planilla = ($meses_edad < 24) ? 'TAL' : 'WDF';

        $datos = [
            'titulo'        => 'Registrar Control',
            'visita'        => $visita,
            'paciente'      => $paciente,
            'tipo_planilla' => $tipo_planilla,
            'meses_edad'    => $meses_edad
        ];

        echo view('templates/header', $datos);
        echo view('visitas/crearcontroles', $datos);
        echo view('templates/footer');
    }

    public function guardar()
    {
        $id_visita = $this->request->getPost('id_visita');
        $medicacion = $this->request->getPost('medicacion');
        $observaciones = $this->request->getPost('observaciones');
        
        // Sintomas, igual que en Visita.php
        $sintomas_enviados = $this->request->getPost('sintomas');

        if ($id_visita && !empty($sintomas_enviados)) {
            
            $visita = $this->visitaModel->find($id_visita);
            $paciente = $this->pacienteModel->find($visita['id_paciente']);
            
            $form = 'TAL';
            if ($paciente && !empty($paciente['fecha_nacimiento'])) {
                $fecha_nac = new \DateTime($paciente['fecha_nacimiento']);
                $hoy = new \DateTime('today');
                $meses = ($fecha_nac->diff($hoy)->y * 12) + $fecha_nac->diff($hoy)->m;
                $form = ($meses < 24) ? 'TAL' : 'WDF';
            }

            $this->controlModel->transStart();

            $id_control_nuevo = $this->controlModel->insert([
                'id_visita'       => $id_visita,
                'fecha_hora'      => date('Y-m-d H:i:s'),
                'medicacion'      => $medicacion,
                'observaciones'   => $observaciones
            ], true);

            $score_total = 0;

            // Puntos, igual que en Visita.php
            foreach ($sintomas_enviados as $idSintoma => $valor) {
                $puntos = 0;
                $builder = $this->valoresSintomasModel->where('id_sintoma', $idSintoma);
                
                if (is_numeric($valor)) {
                    $fila = $builder->where('valor_min IS NOT NULL')
                                    ->where('valor_min <=', $valor)
                                    ->orderBy('valor_min', 'DESC')
                                    ->first();
                } else {
                    $fila = $builder->where('valor_texto', $valor)->first();
                }

                if ($fila) {
                    $puntos = (int) $fila['puntos'];
                }

                $score_total += $puntos;

                $this->controlSintomasModel->insert([
                    'id_control'       => $id_control_nuevo,
                    'id_sintoma'       => (int) $idSintoma,
                    'valor_registrado' => (string) $valor,
                ]);
            }

            $gravedad = null;
            if ($form === 'WDF') {
                $gravedad = 'Grave';
                if ($score_total <= 3) $gravedad = 'Leve';
                elseif ($score_total <= 7) $gravedad = 'Moderada';
            }

            $this->controlModel->update($id_control_nuevo, [
                'score_total'     => $score_total,
                'estado_gravedad' => $gravedad
            ]);

            $this->controlModel->transComplete();
        }

        return redirect()->to(base_url('visitas/ver/' . $id_visita))->with('mensaje', 'Control evolutivo registrado correctamente.');
    }
}