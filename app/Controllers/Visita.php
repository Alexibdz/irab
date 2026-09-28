<?php

namespace App\Controllers;

use App\Models\VisitaModel;
use App\Models\PacienteModel;
use App\Models\UsuariosModel;
use App\Models\EstablecimientosModel;
use App\Models\ControlModel;
use App\Models\FactoresModel;
use App\Models\PacienteFactoresModel;
use App\Models\ControlSintomasModel;
use App\Models\ValoresSintomasModel;


class Visita extends BaseController
{
    protected $visitaModel;
    protected $usuarioModel;
    protected $pacienteModel;
    protected $establecimientoModel;
    protected $controlModel;
    protected $factoresModel;
    protected $pacienteFactoresModel;
    protected $controlSintomasModel;
    protected $valoresSintomasModel;

    public function __construct()
    {
        $this->visitaModel = new VisitaModel();
        $this->pacienteModel = new PacienteModel();
        $this->usuarioModel = new UsuariosModel();
        $this->establecimientoModel = new EstablecimientosModel();
        $this->factoresModel = new FactoresModel();
        $this->controlModel = new ControlModel();
        $this->pacienteFactoresModel = new PacienteFactoresModel();
        $this->controlSintomasModel = new ControlSintomasModel();
        $this->valoresSintomasModel = new ValoresSintomasModel();
    }

    public function index()
    {
        $datos = [
            'visitas' => $this->visitaModel->findAll(),
            'pacientes' => $this->pacienteModel->findAll(),
            'usuarios' => $this->usuarioModel->findAll(),
            'establecimientos' => $this->establecimientoModel->findAll()
        ];

        echo view('templates/header', $datos);
        echo view('visitas/index', $datos);
        echo view('templates/footer');
    }

    public function crear()
    {
        $datos = [
            'titulo' => 'Registrar visita',
            'pacientes' => $this->pacienteModel->findAll(),
            'usuarios' => $this->usuarioModel->findAll(),
            'establecimientos' => $this->establecimientoModel->findAll(),
            'factores' => $this->factoresModel->findAll()
        ];

        echo view('templates/header', $datos);
        echo view('visitas/crear', $datos);
        echo view('templates/footer');
    }

    public function insertar()
    {
        // el ID del paciente
        $id_paciente = $this->request->getPost('id_paciente');

        // Preparamos los datos de la visita principal
        $datos = [
            'id_paciente'              => $id_paciente,
            'id_usuario'               => $this->request->getPost('id_usuario'),
            'id_establecimiento'       => $this->request->getPost('id_establecimiento'),
            'fecha_ingreso'            => $this->request->getPost('fecha_ingreso'),
            'diagnostico'              => $this->request->getPost('diagnostico'),
            'estado_derivacion'        => $this->request->getPost('estado_derivacion'),
            'id_turno_protegido_lugar' => $this->request->getPost('id_turno_protegido_lugar'),
            'turno_protegido_fecha'    => $this->request->getPost('turno_protegido_fecha'),
            'medicacion_egreso'        => $this->request->getPost('medicacion_egreso'),
            'fecha_alta'               => $this->request->getPost('fecha_alta'),
            'observaciones_finales'    => $this->request->getPost('observaciones_finales')
        ];

        // Guardamos la visita principal
        $id_visita_nueva = $this->visitaModel->insert($datos);

        //  Asociamos los factores de riesgo y protección
        $factores_seleccionados = $this->request->getPost('factores');
        if ($id_visita_nueva && !empty($factores_seleccionados)) {
            foreach ($factores_seleccionados as $id_factor => $valor_registrado) {
                $this->pacienteFactoresModel->insert([
                    'id_visita'        => $id_visita_nueva,
                    'id_paciente'      => $id_paciente,
                    'id_factor'        => $id_factor,
                    'valor_registrado' => $valor_registrado
                ]);
            }
        }

        // CONTROL CLÍNICO 
        $sintomas_enviados = $this->request->getPost('sintomas');
        
        if ($id_visita_nueva && !empty($sintomas_enviados)) {
            
            // Calcula edad y determina escala (TAL o WDF)
            $paciente = $this->pacienteModel->find($id_paciente);
            $form = 'TAL'; // por defecto
            
            if ($paciente && !empty($paciente['fecha_nacimiento'])) {
                $fecha_nac = new \DateTime($paciente['fecha_nacimiento']);
                $hoy = new \DateTime('today');
                $meses = ($fecha_nac->diff($hoy)->y * 12) + $fecha_nac->diff($hoy)->m;
                $form = ($meses < 24) ? 'TAL' : 'WDF';
            }

            // Iniciar transacción manual para proteger los datos
            $this->controlModel->transStart();

            // Insertar el control base o primer control de la visita para obtener su ID
            $idControl = $this->controlModel->insert([
                'id_visita'     => $id_visita_nueva,
                'fecha_hora'    => date('Y-m-d H:i:s'),
                'medicacion'    => 'Ninguna (Ingreso)',
                'observaciones' => 'Control clínico inicial al ingreso.'
            ], true);

            $score_total = 0;

            //Recorre los síntomas enviados y calcula puntos
            foreach ($sintomas_enviados as $idSintoma => $valor) {
                $puntos = 0;
                
                // Busca el puntaje en la base de datos
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

                // Guarda cada síntoma asociado al control
                $this->controlSintomasModel->insert([
                    'id_control'       => $idControl,
                    'id_sintoma'       => (int) $idSintoma,
                    'valor_registrado' => (string) $valor,
                ]);
            }

            //  Calcula la gravedad según los cortes de la escala correspondiente
            $gravedad = 'Grave';
            if ($form === 'TAL') {
                if ($score_total <= 5) $gravedad = 'Leve';
                elseif ($score_total <= 8) $gravedad = 'Moderada';
            } else {
                // Cortes para WDF
                if ($score_total <= 3) $gravedad = 'Leve';
                elseif ($score_total <= 7) $gravedad = 'Moderada';
            }
            // Calcula la gravedad según los cortes de la escala correspondiente
            $gravedad = null; // Para la escala TAL (menores de 2 años) no se guarda gravedad

            if ($form === 'WDF') {
                // Cortes exclusivos para WDF (2 a 5 años)
                $gravedad = 'Grave'; // Valor por defecto si supera los 7 puntos
                
                if ($score_total <= 3) {
                    $gravedad = 'Leve';
                } elseif ($score_total <= 7) {
                    $gravedad = 'Moderada';
                }
            }

            //  Actualiza el control con el resultado final
            $this->controlModel->update($idControl, [
                'score_total'     => $score_total,
                'estado_gravedad' => $gravedad
            ]);

            // Completa la transacción
            $this->controlModel->transComplete();
        }

        return redirect()->to(base_url('visitas'));
    }

    public function editar($id)
    {
        $visita = $this->visitaModel->find($id);

        if (!$visita) {
            return redirect()->to(base_url('visitas'))
                ->with('error', 'La visita no existe.');
        }

        $datos = [
            'titulo' => 'Editar visita',
            'visita' => $visita,
            'pacientes' => $this->pacienteModel->findAll(),
            'usuarios' => $this->usuarioModel->findAll(),
            'establecimientos' => $this->establecimientoModel->findAll()
        ];

        echo view('templates/header', $datos);
        echo view('visitas/editar', $datos);
        echo view('templates/footer');
    }

    public function actualizar()
    {
        $id = $this->request->getPost('id');
    
        $datos = [
            'id_paciente'              => $this->request->getPost('id_paciente'),
            'id_usuario'               => $this->request->getPost('id_usuario'),
            'id_establecimiento'       => $this->request->getPost('id_establecimiento'),
            'fecha_ingreso'            => $this->request->getPost('fecha_ingreso'),
            'diagnostico'              => $this->request->getPost('diagnostico'),
            'estado_derivacion'        => $this->request->getPost('estado_derivacion'),
            'id_turno_protegido_lugar' => $this->request->getPost('id_turno_protegido_lugar'),
            'turno_protegido_fecha'    => $this->request->getPost('turno_protegido_fecha'),
            'medicacion_egreso'        => $this->request->getPost('medicacion_egreso'),
            'fecha_alta'               => $this->request->getPost('fecha_alta'),
            'observaciones_finales'    => $this->request->getPost('observaciones_finales')
        ];
    
        $this->visitaModel->update($id, $datos);
    
        return redirect()->to(base_url('visitas'));
    }


    public function borrar($id)
    {
        $this->visitaModel->delete($id);

        return redirect()->to(base_url('visitas'));
    }

    public function eliminados()
    {
        $datos = [
            'titulo' => 'Visitas eliminadas',
            'visitas' => $this->visitaModel->onlyDeleted()->findAll()
        ];

        echo view('templates/header', $datos);
        echo view('visitas/eliminados', $datos);
        echo view('templates/footer');
    }

    public function recuperar($id)
    {
        $this->visitaModel->update($id, [
            'fecha_borrado' => null
        ]);

        return redirect()->to(base_url('visitas/eliminados'));
    }

    public function ver($id_visita)
    {
        $visita = $this->visitaModel->find($id_visita);

        if (!$visita) {
            return redirect()->to(base_url('visitas'))->with('error', 'La visita no existe.');
        }

        $controles = $this->controlModel->where('id_visita', $id_visita)->findAll();
        $factoresRegistrados = $this->pacienteFactoresModel->where('id_visita', $id_visita)->findAll();
        $todosLosFactores = $this->factoresModel->findAll();

        $datos = [
            'titulo' => 'Detalle de Visita e Historial de Controles',
            'visita' => $visita,
            'controles' => $controles,
            'factoresRegistrados' => $factoresRegistrados,
            'todosLosFactores' => $todosLosFactores
        ];

        echo view('templates/header', $datos);
        echo view('visitas/ver', $datos);
        echo view('templates/footer');
    }
}