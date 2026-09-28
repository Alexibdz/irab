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

    /**
     * Visitas ABIERTAS: las que todavia no tienen fecha de alta.
     * Las cerradas se ven en historial().
     */
    public function index()
    {
        $datos = [
            'titulo' => 'Visitas abiertas',
            'visitas' => $this->visitaModel->where('fecha_alta IS NULL')->findAll(),
            'cerradas' => $this->visitaModel->where('fecha_alta IS NOT NULL')->countAllResults(),
            'pacientes' => $this->pacienteModel->findAll(),
            'usuarios' => $this->usuarioModel->findAll(),
            'establecimientos' => $this->establecimientoModel->findAll()
        ];

        echo view('templates/header', $datos);
        echo view('visitas/index', $datos);
        echo view('templates/footer');
    }

    /**
     * Historial: visitas ya CERRADAS, con sus datos de egreso.
     */
    public function historial()
    {
        $datos = [
            'titulo' => 'Historial de visitas',
            'visitas' => $this->visitaModel->where('fecha_alta IS NOT NULL')
                                           ->orderBy('fecha_alta', 'DESC')
                                           ->findAll(),
            'abiertas' => $this->visitaModel->where('fecha_alta IS NULL')->countAllResults(),
            'pacientes' => $this->pacienteModel->findAll(),
            'usuarios' => $this->usuarioModel->findAll(),
            'establecimientos' => $this->establecimientoModel->findAll()
        ];

        echo view('templates/header', $datos);
        echo view('visitas/historial', $datos);
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

        // La visita nace ABIERTA: los datos de egreso quedan en NULL y se
        // completan despues desde "Cerrar visita" en la pantalla de detalle.
        $datos = [
            'id_paciente'              => $id_paciente,
            'id_usuario'               => $this->request->getPost('id_usuario'),
            'id_establecimiento'       => $this->request->getPost('id_establecimiento'),
            'fecha_ingreso'            => $this->request->getPost('fecha_ingreso'),
            'diagnostico'              => $this->request->getPost('diagnostico'),
            'estado_derivacion'        => null,
            'id_turno_protegido_lugar' => null,
            'turno_protegido_fecha'    => null,
            'medicacion_egreso'        => null,
            'fecha_alta'               => null,
            'observaciones_finales'    => null
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
    
        // Solo los datos de ingreso. Los de egreso se manejan desde
        // "Cerrar visita", en la pantalla de detalle.
        $datos = [
            'id_paciente'        => $this->request->getPost('id_paciente'),
            'id_usuario'         => $this->request->getPost('id_usuario'),
            'id_establecimiento' => $this->request->getPost('id_establecimiento'),
            'fecha_ingreso'      => $this->request->getPost('fecha_ingreso'),
            'diagnostico'        => $this->request->getPost('diagnostico')
        ];

        $this->visitaModel->update($id, $datos);

        // Volvemos al detalle y no al listado, porque si la visita esta cerrada
        // el listado de abiertas no la muestra y parece que no se guardo nada.
        return redirect()->to(base_url('visitas/ver/' . $id))->with('exito', 'Visita actualizada correctamente.');
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

    /**
     * Devuelve null cuando el campo del formulario vino vacio.
     * Sin esto, un <input type="date"> sin completar manda "" y MySQL lo
     * guarda como 0000-00-00 en vez de NULL, y un <select> sin elegir
     * manda "" que en una columna ENUM se guarda como cadena vacia.
     */
    private function nullSiVacio($valor)
    {
        return ($valor === null || trim((string) $valor) === '') ? null : $valor;
    }

    /**
     * Cierra la visita: guarda los datos de egreso.
     * Una visita se considera CERRADA cuando tiene fecha_alta.
     */
    public function cerrar()
    {
        $id_visita = $this->request->getPost('id_visita');

        $visita = $this->visitaModel->find($id_visita);
        if (!$visita) {
            return redirect()->to(base_url('visitas'))->with('error', 'La visita no existe.');
        }

        $fecha_alta = $this->nullSiVacio($this->request->getPost('fecha_alta'));

        if ($fecha_alta === null) {
            return redirect()->to(base_url('visitas/ver/' . $id_visita))
                ->with('error', 'Para cerrar la visita hace falta la fecha de alta.');
        }

        $this->visitaModel->update($id_visita, [
            'estado_derivacion'        => $this->nullSiVacio($this->request->getPost('estado_derivacion')),
            'id_turno_protegido_lugar' => $this->nullSiVacio($this->request->getPost('id_turno_protegido_lugar')),
            'turno_protegido_fecha'    => $this->nullSiVacio($this->request->getPost('turno_protegido_fecha')),
            'medicacion_egreso'        => $this->nullSiVacio($this->request->getPost('medicacion_egreso')),
            'fecha_alta'               => $fecha_alta,
            'observaciones_finales'    => $this->nullSiVacio($this->request->getPost('observaciones_finales'))
        ]);

        return redirect()->to(base_url('visitas/ver/' . $id_visita))
            ->with('exito', 'Visita cerrada correctamente.');
    }

    /**
     * Reabre una visita: limpia los datos de egreso y vuelve a quedar abierta.
     */
    public function reabrir($id_visita)
    {
        $visita = $this->visitaModel->find($id_visita);
        if (!$visita) {
            return redirect()->to(base_url('visitas'))->with('error', 'La visita no existe.');
        }

        $this->visitaModel->update($id_visita, [
            'estado_derivacion'        => null,
            'id_turno_protegido_lugar' => null,
            'turno_protegido_fecha'    => null,
            'medicacion_egreso'        => null,
            'fecha_alta'               => null,
            'observaciones_finales'    => null
        ]);

        return redirect()->to(base_url('visitas/ver/' . $id_visita))
            ->with('exito', 'Visita reabierta.');
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
            'todosLosFactores' => $todosLosFactores,
            'establecimientos' => $this->establecimientoModel->findAll()
        ];

        echo view('templates/header', $datos);
        echo view('visitas/ver', $datos);
        echo view('templates/footer');
    }
}