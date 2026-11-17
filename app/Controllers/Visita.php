<?php

namespace App\Controllers;

use App\Models\VisitaModel;
use App\Models\PacienteModel;
use App\Models\TutorModel;
use App\Models\UsuariosModel;
use App\Models\EstablecimientosModel;
use App\Models\ControlModel;
use App\Models\FactoresModel;
use App\Models\PacienteFactoresModel;
use App\Models\ControlSintomasModel;
use App\Models\ValoresSintomasModel;
use App\Models\MedicacionModel;
use App\Models\ControlMedicacionModel;


class Visita extends BaseController
{
    protected $visitaModel;
    protected $usuarioModel;
    protected $pacienteModel;
    protected $tutorModel;
    protected $establecimientoModel;
    protected $controlModel;
    protected $factoresModel;
    protected $pacienteFactoresModel;
    protected $controlSintomasModel;
    protected $valoresSintomasModel;
    protected $medicacionModel;
    protected $controlMedicacionModel;

    public function __construct()
    {
        $this->visitaModel = new VisitaModel();
        $this->pacienteModel = new PacienteModel();
        $this->tutorModel = new TutorModel();
        $this->usuarioModel = new UsuariosModel();
        $this->establecimientoModel = new EstablecimientosModel();
        $this->factoresModel = new FactoresModel();
        $this->controlModel = new ControlModel();
        $this->pacienteFactoresModel = new PacienteFactoresModel();
        $this->controlSintomasModel = new ControlSintomasModel();
        $this->valoresSintomasModel = new ValoresSintomasModel();
        $this->medicacionModel = new MedicacionModel();
        $this->controlMedicacionModel = new ControlMedicacionModel();
        helper('form');
    }

    // Listado de visitas abiertas
    public function index()
    {
        $datos = [
            'titulo' => 'Visitas abiertas',
            // Abierta = sin cierre y sin alta definitiva (visitas viejas pueden tener solo el alta definitiva)
            'visitas' => $this->visitaModel->where('fecha_alta IS NULL AND fecha_alta_definitiva IS NULL')->findAll(),
            'cerradas' => $this->visitaModel->where('(fecha_alta IS NOT NULL OR fecha_alta_definitiva IS NOT NULL)')->countAllResults(),
            'pacientes' => $this->pacienteModel->findAll(),
            'usuarios' => $this->usuarioModel->findAll(),
            'establecimientos' => $this->establecimientoModel->findAll()
        ];

        echo view('templates/header', $datos);
        echo view('visitas/index', $datos);
        echo view('templates/footer');
    }

    // Listado de visitas cerradas
    // ?tipo=todas (default) | cerradas (en curso: cierre temporal, se pueden reabrir) | altas (alta definitiva)
    public function historial()
    {
        $tipo = $this->request->getGet('tipo');
        if (!in_array($tipo, ['todas', 'cerradas', 'altas'], true)) {
            $tipo = 'todas';
        }

        $soloCerradas = 'fecha_alta IS NOT NULL AND fecha_alta_definitiva IS NULL';
        $soloAltas    = 'fecha_alta_definitiva IS NOT NULL';
        $todas        = '(fecha_alta IS NOT NULL OR fecha_alta_definitiva IS NOT NULL)';

        $filtros = ['todas' => $todas, 'cerradas' => $soloCerradas, 'altas' => $soloAltas];

        $visitas = $this->visitaModel->where($filtros[$tipo])
            ->orderBy('COALESCE(fecha_alta_definitiva, fecha_alta)', 'DESC', false)
            ->findAll();

        $datos = [
            'titulo' => 'Historial de visitas',
            'tipo' => $tipo,
            'visitas' => $visitas,
            'totalCerradas' => $this->visitaModel->where($soloCerradas)->countAllResults(),
            'totalAltas' => $this->visitaModel->where($soloAltas)->countAllResults(),
            'abiertas' => $this->visitaModel->where('fecha_alta IS NULL AND fecha_alta_definitiva IS NULL')->countAllResults(),
            'pacientes' => $this->pacienteModel->findAll(),
            'usuarios' => $this->usuarioModel->findAll(),
            'establecimientos' => $this->establecimientoModel->findAll()
        ];

        echo view('templates/header', $datos);
        echo view('visitas/historial', $datos);
        echo view('templates/footer');
    }

    // Alta de visita: paso 1 sin id, paso 2 con id
    public function crear($id_paciente = null)
    {
        if ($id_paciente !== null) {
            return $this->formulario($id_paciente);
        }

        $q = trim((string) $this->request->getGet('q'));
        $pacientes = $q === '' ? [] : $this->buscarPacientes($q);
        $digitosBusqueda = preg_replace('/\D/', '', $q);
        $dniBusqueda = preg_match('/^[0-9.\s]+$/', $q) && strlen($digitosBusqueda) === 8
            ? $digitosBusqueda
            : '';
        $dniPaciente = old('dni');
        if ($dniPaciente === null) {
            $dniPaciente = $dniBusqueda !== '' && empty($pacientes) ? $dniBusqueda : '';
        }

        $datos = [
            'titulo' => 'Nueva visita',
            'q' => $q,
            'pacientes' => $pacientes,
            'panelAbierto' => !empty(old('nombre')) || ($dniBusqueda !== '' && empty($pacientes)),
            'dniPaciente' => $dniPaciente,
            'establecimientos' => $this->establecimientoModel->findAll()
        ];

        echo view('templates/header', $datos);
        echo view('visitas/paso1', $datos);
        echo view('templates/footer');
    }

    // Paso 2: formulario clinico
    private function formulario($id_paciente)
    {
        $paciente = $this->pacienteModel->find($id_paciente);

        if (!$paciente) {
            return redirect()->to(base_url('visitas/crear'))
                ->with('error', 'El paciente no existe.');
        }

        $datos = [
            'titulo' => 'Registrar visita',
            'paciente' => $paciente,
            'tutor' => $this->tutorModel->find($paciente['id_tutor']),
            'usuarios' => $this->usuarioModel->findAll(),
            'idUsuarioActual' => session()->get('id_usuario'),
            'establecimientos' => $this->establecimientoModel->findAll(),
            'factores' => $this->factoresModel->findAll(),
            'medicaciones' => $this->medicacionModel->orderBy('nombre')->findAll()
        ];

        echo view('templates/header', $datos);
        echo view('visitas/crear', $datos);
        echo view('templates/footer');
    }

    // Busqueda de pacientes por nombre o DNI propio
    private function buscarPacientes(string $q): array
    {
        $digitos = preg_replace('/\D/', '', $q);

        // Soft delete a mano: builder() no lo aplica
        $builder = $this->pacienteModel->builder()
            ->select('pacientes.*, tutores.nombre AS tutor_nombre, tutores.apellido AS tutor_apellido, tutores.telefono AS tutor_telefono')
            ->join('tutores', 'tutores.id = pacientes.id_tutor', 'left')
            ->where('pacientes.fecha_borrado IS NULL')
            ->groupStart()
                ->like('pacientes.nombre', $q)
                ->orLike('pacientes.apellido', $q)
                ->orLike('pacientes.dni', $q);

        // DNI sin puntos
        if ($digitos !== '') {
            $builder->orWhere("REPLACE(REPLACE(pacientes.dni, '.', ''), ' ', '') LIKE", '%' . $digitos . '%');
        }

        $pacientes = $builder->groupEnd()
            ->orderBy('pacientes.nombre')
            ->orderBy('pacientes.apellido')
            ->limit(15)
            ->get()
            ->getResultArray();

        if (empty($pacientes)) {
            return [];
        }

        // Visitas previas por paciente
        $conteos = $this->visitaModel->builder()
            ->select('id_paciente, COUNT(*) AS total')
            ->where('fecha_borrado IS NULL')
            ->whereIn('id_paciente', array_column($pacientes, 'id'))
            ->groupBy('id_paciente')
            ->get()
            ->getResultArray();

        $visitasPor = array_column($conteos, 'total', 'id_paciente');

        foreach ($pacientes as &$paciente) {
            $paciente['visitas_previas'] = (int) ($visitasPor[$paciente['id']] ?? 0);
        }

        return $pacientes;
    }

    // Busqueda de pacientes (JSON): por GET, no rota el token CSRF
    public function buscarPaciente()
    {
        $q = trim((string) $this->request->getGet('q'));

        if (mb_strlen($q) < 2) {
            return $this->response->setJSON([]);
        }

        return $this->response->setJSON($this->buscarPacientes($q));
    }

    // Busqueda de tutores (JSON): por GET, no rota el token CSRF
    public function buscarTutor()
    {
        $q = trim((string) $this->request->getGet('q'));

        if (mb_strlen($q) < 2) {
            return $this->response->setJSON([]);
        }

        $digitos = preg_replace('/\D/', '', $q);

        $builder = $this->tutorModel->builder()
            ->select('id, nombre, apellido, dni, telefono')
            ->where('fecha_borrado IS NULL')
            ->groupStart()
                ->like('nombre', $q)
                ->orLike('apellido', $q)
                ->orLike('dni', $q);

        if ($digitos !== '') {
            $builder->orLike('telefono', $digitos)
                    ->orWhere("REPLACE(REPLACE(dni, '.', ''), ' ', '') LIKE", '%' . $digitos . '%');
        }

        $tutores = $builder->groupEnd()
            ->orderBy('nombre')
            ->orderBy('apellido')
            ->limit(8)
            ->get()
            ->getResultArray();

        return $this->response->setJSON($tutores);
    }

    // Alta de paciente y tutor, en transaccion
    public function pacienteNuevo()
    {
        // reglas
        $reglas = [
            //el dni vacio por ej si el bebe todav no tiene dni, pero si lo tiene no puede repetirse
            'dni'                         => 'permit_empty|numeric|min_length[7]|max_length[8]|is_unique[pacientes.dni]',
            'nombre'                      => 'required|min_length[2]|max_length[100]',
            'apellido'                    => 'required|min_length[2]|max_length[100]',
            'fecha_nacimiento'            => 'required|valid_date',
            'tutor_nombre'                 => 'permit_empty|min_length[2]|max_length[100]',
            'tutor_apellido'               => 'permit_empty|min_length[2]|max_length[100]',
            'id_establecimiento_habitual' => 'required',
            'tutor_dni'                   => 'permit_empty|numeric|min_length[7]|max_length[8]',
            'tutor_telefono'              => 'permit_empty|numeric|min_length[6]|max_length[15]'
        ];

        $mensajes = [
            'dni' => [
                'numeric'   => 'El DNI solo deben ser números.',
                'is_unique' => 'Este DNI ya se encuentra registrado en otro paciente.',
                'min_length' => 'El DNI debe tener al menos 7 dígitos.',
                'max_length' => 'El DNI no puede tener más de 8 dígitos.',
            ],
            'tutor_dni' => [
                'numeric' => 'El DNI solo deben ser números.',
                'min_length' => 'El DNI del tutor debe tener al menos 7 dígitos.',
                'max_length' => 'El DNI del tutor no puede tener más de 8 dígitos.'
            ],
            'tutor_telefono' => [
                'numeric' => 'El teléfono deben ser números.',
                'min_length' => 'El teléfono debe tener al menos 6 dígitos.',
                'max_length' => 'El teléfono no puede tener más de 15 dígitos.'
            ],
            'nombre' => [
                'required'   => 'El nombre del paciente es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 2 caracteres.'
            ],
            'apellido' => [
                'required'   => 'El apellido del paciente es obligatorio.',
                'min_length' => 'El apellido debe tener al menos 2 caracteres.'
            ],
            'fecha_nacimiento' => [
                'required'   => 'La fecha de nacimiento es obligatoria.',
                'valid_date' => 'Debe ingresar una fecha válida.'
            ],
            'id_establecimiento_habitual' => [
                'required' => 'Debe seleccionar el establecimiento habitual del paciente.'
            ]
        ];

        // with input te guarda si ya estabas completando el campo, y te lo devuelve en el formulario
        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_tutor = $this->request->getPost('id_tutor');
        $dni      = trim((string) $this->request->getPost('tutor_dni'));
        $telefono = trim((string) $this->request->getPost('tutor_telefono'));
        $nombre   = trim((string) $this->request->getPost('tutor_nombre'));
        $apellido = trim((string) $this->request->getPost('tutor_apellido'));

        // Tutor registrado sin elegir
        if ($this->request->getPost('modo_tutor') === 'existente' && empty($id_tutor)) {
            return redirect()->back()->withInput()
                ->with('errors', ['tutor' => 'Buscá y elegí un tutor de la lista, o seleccioná "Tutor nuevo".']);
        }

        // Tutor nuevo: deduplica por DNI o telefono
        if (empty($id_tutor)) {
            if ($dni === '' || $nombre === '' || $apellido === '') {
                return redirect()->back()->withInput()
                    ->with('errors', ['tutor' => 'Para registrar un tutor nuevo hacen falta el DNI, el nombre y el apellido.']);
            }

            $tutor = $this->tutorModel->where('dni', $dni)->first();

            if (!$tutor && $telefono !== '') {
                $tutor = $this->tutorModel->where('telefono', $telefono)->first();
            }

            $id_tutor = $tutor['id'] ?? null;
        }

        $this->pacienteModel->transStart();

        if (empty($id_tutor)) {
            $id_tutor = $this->tutorModel->insert([
                'dni'      => $dni,
                'nombre'   => $nombre,
                'apellido' => $apellido,
                'telefono' => $this->nullSiVacio($telefono)
            ]);
        }

        $id_paciente = $this->pacienteModel->insert([
            'dni'                         => $this->nullSiVacio($this->request->getPost('dni')),
            'nombre'                      => trim($this->request->getPost('nombre')),
            'apellido'                    => trim($this->request->getPost('apellido')),
            'fecha_nacimiento'            => $this->request->getPost('fecha_nacimiento'),
            'id_tutor'                    => $id_tutor,
            'domicilio'                   => $this->nullSiVacio($this->request->getPost('domicilio')),
            'barrio'                      => $this->nullSiVacio($this->request->getPost('barrio')),
            'id_area_programatica'        => $this->nullSiVacio($this->request->getPost('id_area_programatica')),
            'id_establecimiento_habitual' => $this->request->getPost('id_establecimiento_habitual')
        ]);

        $this->pacienteModel->transComplete();

        if (!$id_paciente) {
            return redirect()->back()->withInput()
                ->with('errors', ['bd' => 'No se pudo registrar el paciente. Revisá que el DNI no esté repetido en el sistema.']);
        }

        return redirect()->to(base_url('visitas/crear/' . $id_paciente))
            ->with('exito', 'Paciente registrado. Ahora cargá la visita.');
    }
    public function insertar()
    {
        $reglas = [
            'id_paciente'        => 'required',
            'id_usuario'         => 'required',
            'id_establecimiento' => 'required',
            'fecha_ingreso'      => 'required|valid_date',
            'diagnostico'        => 'required',
            'sintomas'           => 'required'
        ];

        $mensajes = [
            'id_paciente'        => ['required' => 'Falta la identificación del paciente.'],
            'id_usuario'         => ['required' => 'Debe seleccionar el Usuario (Enfermera/Médico).'],
            'id_establecimiento' => ['required' => 'Debe seleccionar el Establecimiento de atención.'],
            'fecha_ingreso'      => [
                'required'   => 'La fecha y hora de ingreso son obligatorias.',
                'valid_date' => 'El formato de fecha no es válido.'
            ],
            'diagnostico'        => ['required' => 'El diagnóstico inicial es obligatorio.'],
            'sintomas'           => ['required' => 'Faltan completar valores en el Control Clínico Inicial (Score).']
        ];

        // hace el with input te guarda si ya estabas completando el campo, y te lo devuelve en el formulario
        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Id del paciente
        $id_paciente = $this->request->getPost('id_paciente');

        // Nace abierta: egreso en NULL
        $datos = [
            'id_paciente'              => $id_paciente,
            'id_usuario'               => $this->request->getPost('id_usuario'),
            'id_establecimiento'       => $this->request->getPost('id_establecimiento'),
            'fecha_ingreso'            => $this->request->getPost('fecha_ingreso'),
            'diagnostico'              => trim($this->request->getPost('diagnostico')),
            'estado_derivacion'        => null,
            'id_turno_protegido_lugar' => null,
            'turno_protegido_fecha'    => null,
            'medicacion_egreso'        => null,
            'fecha_alta'               => null,
            'observaciones_finales'    => null
        ];

        // Visita
        $id_visita_nueva = $this->visitaModel->insert($datos);

        // Factores de riesgo y proteccion
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

        // Control clinico
        $sintomas_enviados = $this->request->getPost('sintomas');
        
        if ($id_visita_nueva && !empty($sintomas_enviados)) {
            
            // Edad y escala
            $paciente = $this->pacienteModel->find($id_paciente);
            $form = 'TAL'; // por defecto
            
            if ($paciente && !empty($paciente['fecha_nacimiento'])) {
                $fecha_nac = new \DateTime($paciente['fecha_nacimiento']);
                $hoy = new \DateTime('today');
                $meses = ($fecha_nac->diff($hoy)->y * 12) + $fecha_nac->diff($hoy)->m;
                $form = ($meses < 24) ? 'TAL' : 'WDF';
            }

            // Transaccion
            $this->controlModel->transStart();

            // Control inicial
            $idControl = $this->controlModel->insert([
                'id_visita'     => $id_visita_nueva,
                'fecha_hora'    => date('Y-m-d H:i:s'),
                'observaciones' => $this->nullSiVacio($this->request->getPost('observaciones') ?? 'Control clínico inicial al ingreso.')
            ], true);

            // Medicaciones administradas (catalogo + dosis)
            $medicaciones_enviadas = $this->request->getPost('medicaciones');
            if (!empty($medicaciones_enviadas) && is_array($medicaciones_enviadas)) {
                $ids_validos = array_column($this->medicacionModel->findAll(), 'id');

                foreach ($medicaciones_enviadas as $fila) {
                    $seleccion_medicacion = (string) ($fila['id_medicacion'] ?? '');
                    $dosis = trim((string) ($fila['dosis'] ?? ''));

                    if ($dosis === '') {
                        continue;
                    }

                    if ($seleccion_medicacion === 'nueva') {
                        $id_medicacion = $this->medicacionModel->obtenerOCrearPorNombre(
                            (string) ($fila['nueva_medicacion'] ?? '')
                        );

                        if ($id_medicacion === false) {
                            $this->controlModel->transComplete();
                            return redirect()->back()->with('errors', [
                                'medicaciones' => 'El nombre de la nueva medicación debe tener entre 2 y 100 caracteres y no estar eliminado del catálogo.'
                            ]);
                        }
                    } else {
                        $id_medicacion = (int) $seleccion_medicacion;
                        if ($id_medicacion === 0 || !in_array($id_medicacion, $ids_validos)) {
                            continue;
                        }
                    }

                    $this->controlMedicacionModel->insert([
                        'id_control'    => $idControl,
                        'id_medicacion' => $id_medicacion,
                        'dosis'         => mb_substr($dosis, 0, 100),
                    ]);
                }
            }

            $score_total = 0;

            // Puntos por síntoma
            foreach ($sintomas_enviados as $idSintoma => $valor) {
                $puntos = 0;
                
                // === EXCLUSIÓN DE PUNTOS PARA SATURACIÓN Y TEMPERATURA ===
                // IDs 6 y 7 (TAL) o 14 y 15 (WDF) solo se guardan pero no suman puntos!!!!
                $esSaturacionOtemperatura = in_array((int)$idSintoma, [6, 7, 14, 15]);

                if (!$esSaturacionOtemperatura) {
                    $builder = $this->valoresSintomasModel->where('id_sintoma', $idSintoma);
                    if (is_numeric($valor)) {
                        $fila = $builder->where('valor_min IS NOT NULL')
                                        ->where('valor_min <=', $valor)
                                        ->where('valor_max >=', $valor)
                                        ->first();
                                        
                        if (!$fila) {
                            $fila = $builder->where('valor_min IS NOT NULL')
                                            ->where('valor_min <=', $valor)
                                            ->orderBy('valor_min', 'DESC')
                                            ->first();
                        }
                    } else {
                        $fila = $builder->where('valor_texto', $valor)->first();
                    }

                    if ($fila) {
                        $puntos = (int) $fila['puntos'];
                    }
                }

                $score_total += $puntos;

                // El valor se guarda en la base de datos 
                $this->controlSintomasModel->insert([
                    'id_control'       => $idControl,
                    'id_sintoma'       => (int) $idSintoma,
                    'valor_registrado' => (string) $valor,
                ]);
            }

            // Gravedad segun la escala
            if ($form === 'WDF') {
                // Cortes WDF (2 a 5 anios): 0-3 Leve, 4-7 Moderada, 8+ Grave
                $gravedad = 'Grave';
                
                if ($score_total <= 3) {
                    $gravedad = 'Leve';
                } elseif ($score_total <= 7) {
                    $gravedad = 'Moderada';
                }
            } else {
                // Cortes TAL (menores de 2 anios): 0-4 Leve, 5-8 Moderada, 9-12 Grave
                $gravedad = 'Grave';

                if ($score_total <= 4) {
                    $gravedad = 'Leve';
                } elseif ($score_total <= 8) {
                    $gravedad = 'Moderada';
                }
            }

            // Resultado final
            $this->controlModel->update($idControl, [
                'score_total'     => $score_total,
                'estado_gravedad' => $gravedad
            ]);

            // cierra la transaccion
            $this->controlModel->transComplete();
            // en tabla auditoria lo registramos:
            $this->registrarAuditoria('visitas', $id_visita_nueva, $id_paciente, 'ALTA', 'Ingreso de visita');
        }

        return redirect()->to(base_url('visitas'))->with('exito', 'Visita clínica registrada correctamente.');
    }
    public function editar($id)
    {
        $visita = $this->visitaModel->find($id);

        if (!$visita) {
            return redirect()->to(base_url('visitas'))
                ->with('error', 'La visita no existe.');
        }

        // Con alta definitiva el caso queda cerrado para siempre
        if (!empty($visita['fecha_alta_definitiva'])) {
            return redirect()->to(base_url('visitas/ver/' . $id))
                ->with('error', 'No se puede editar una visita con alta definitiva.');
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

        $actual = $this->visitaModel->find($id);
        if (!$actual) {
            return redirect()->to(base_url('visitas'))->with('error', 'La visita no existe.');
        }
        if (!empty($actual['fecha_alta_definitiva'])) {
            return redirect()->to(base_url('visitas/ver/' . $id))
                ->with('error', 'No se puede editar una visita con alta definitiva.');
        }

        $reglas = [
            'id_paciente'        => 'required',
            'id_usuario'         => 'required',
            'id_establecimiento' => 'required',
            'fecha_ingreso'      => 'required|valid_date',
            'diagnostico'        => 'required'
        ];

        $mensajes = [
            'id_paciente'        => ['required' => 'Debe seleccionar un paciente.'],
            'id_usuario'         => ['required' => 'Debe seleccionar un usuario.'],
            'id_establecimiento' => ['required' => 'Debe seleccionar un establecimiento.'],
            'fecha_ingreso'      => [
                'required'   => 'La fecha de ingreso es obligatoria.',
                'valid_date' => 'Formato de fecha inválido.'
            ],
            'diagnostico'        => ['required' => 'El diagnóstico es obligatorio.']
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }
    
        // Solo datos de ingreso
        $datos = [
            'id_paciente'        => $this->request->getPost('id_paciente'),
            'id_usuario'         => $this->request->getPost('id_usuario'),
            'id_establecimiento' => $this->request->getPost('id_establecimiento'),
            'fecha_ingreso'      => $this->request->getPost('fecha_ingreso'),
            'diagnostico'        => trim($this->request->getPost('diagnostico'))
        ];

        $this->visitaModel->update($id, $datos);
        //aca registramos en auditoria la modificacion
        $this->registrarAuditoria('visitas', $id, $this->request->getPost('id_paciente'), 'MODIFICACION', 'Modificación de datos de ingreso de la visita.');

        return redirect()->to(base_url('visitas/ver/' . $id))->with('exito', 'Visita actualizada correctamente.');
    }

    public function borrar($id)
    {
        $visita = $this->visitaModel->find($id);
        // el soft
        $this->visitaModel->delete($id);
        // Si la visita existía, registramos la baja en la tabla de auditoría
        if ($visita) {
            $this->registrarAuditoria('visitas',$id, $visita['id_paciente'],'BAJA','Softdelete de la visita');
        }
        return redirect()->to(base_url('visitas'));
    }

    public function eliminados()
    {
        // Consulta con LEFT JOIN para incluir nombres de paciente, usuario y establecimiento en cada fila
        $visitas = $this->visitaModel->builder()
            ->select('visitas.*, 
                      CONCAT(pacientes.nombre, " ", pacientes.apellido) AS paciente,
                      CONCAT(usuarios.nombre, " ", usuarios.apellido) AS usuario,
                      establecimientos_salud.nombre AS establecimiento')
            ->join('pacientes', 'pacientes.id = visitas.id_paciente', 'left')
            ->join('usuarios', 'usuarios.id = visitas.id_usuario', 'left')
            ->join('establecimientos_salud', 'establecimientos_salud.id = visitas.id_establecimiento', 'left')
            ->where('visitas.fecha_borrado IS NOT NULL')
            ->orderBy('visitas.fecha_borrado', 'DESC')
            ->get()
            ->getResultArray();

        $datos = [
            'titulo'  => 'Visitas eliminadas',
            'visitas' => $visitas
        ];

        echo view('templates/header', $datos);
        echo view('visitas/eliminados', $datos);
        echo view('templates/footer');
    }

public function recuperar($id)
    {
        // withDeleted() porque la visita actualmente tiene fecha_borrado cargada
        $visita = $this->visitaModel->withDeleted()->find($id);
        $this->visitaModel->update($id, [
            'fecha_borrado' => null
        ]);

        if ($visita) {
            //lo registra en auditoria tmb
            $this->registrarAuditoria('visitas',$id,$visita['id_paciente'],'RECUPERACION','Restauración de visita eliminada.');
        }
        return redirect()->to(base_url('visitas/eliminados'));
    }

    // Campo vacio a NULL: evita 0000-00-00 en date y '' en ENUM
    private function nullSiVacio($valor)
    {
        return ($valor === null || trim((string) $valor) === '') ? null : $valor;
    }

    // Cierre de visita: carga el egreso, fecha_alta la marca cerrada (se cierra visita NO ALTA MEDICA)
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

        $this->registrarAuditoria('visitas', $id_visita, $visita['id_paciente'], 'CIERRE', 'Cierre temporal de visita.');

        return redirect()->to(base_url('visitas/ver/' . $id_visita))
            ->with('exito', 'Visita cerrada correctamente.');
    }
    // Registrar el Alta Definitiva: es como un alta medico definitivo, porq sino seria cerrar una visita 
    public function darAltaDefinitiva($id_visita)
    {
        $visita = $this->visitaModel->find($id_visita);
        if (!$visita) {
            return redirect()->to(base_url('visitas'))->with('error', 'La visita no existe.');
        }

        if (!empty($visita['fecha_alta_definitiva'])) {
            return redirect()->to(base_url('visitas/ver/' . $id_visita))
                ->with('error', 'La visita ya tiene alta definitiva.');
        }

        // se actualiza la alta definitiva con la fecha y hora.
        // Si la visita seguia abierta, tambien se cierra (fecha_alta es lo que la marca cerrada)
        $this->visitaModel->update($id_visita, [
            'fecha_alta_definitiva' => date('Y-m-d H:i:s'),
            'fecha_alta'            => $visita['fecha_alta'] ?: date('Y-m-d')
        ]);
        $this->registrarAuditoria('visitas', $id_visita, $visita['id_paciente'], 'ALTA_DEFINITIVA', 'Alta médica otorgada.');
        return redirect()->to(base_url('panel'))
            ->with('exito', 'Alta medica del paciente (debera volver a hacerse una visita si vuelve a presentar sintomas ).');
    }
    // Reapertura de visita: limpia el egreso
    public function reabrir($id_visita)
    {
        $visita = $this->visitaModel->find($id_visita);
        if (!$visita) {
            return redirect()->to(base_url('visitas'))->with('error', 'La visita no existe.');
        }

        // si ya tiene alta definitiva, no se puede reabrir
        if (!empty($visita['fecha_alta_definitiva'])) {
            return redirect()->to(base_url('visitas/ver/' . $id_visita))
                ->with('error', 'No se puede reabrir una visita ya dada de alta definitiva ');
        }

        $this->visitaModel->update($id_visita, [
            'estado_derivacion'        => null,
            'id_turno_protegido_lugar' => null,
            'turno_protegido_fecha'    => null,
            'medicacion_egreso'        => null,
            'fecha_alta'               => null, //esta fecha es de alta de visita, no de TODO
            'observaciones_finales'    => null
        ]);
        $this->registrarAuditoria('visitas', $id_visita, $visita['id_paciente'], 'REAPERTURA', 'Reapertura para continuar controles.');

        return redirect()->to(base_url('visitas/ver/' . $id_visita))
            ->with('exito', 'Visita reabierta para seguir controlando');
    }

    public function ver($id_visita)
    {
        $visita = $this->visitaModel->find($id_visita);

        if (!$visita) {
            return redirect()->to(base_url('visitas'))->with('error', 'La visita no existe.');
        }

        $controles = $this->controlModel->where('id_visita', $id_visita)->findAll();

        // Síntomas registrados en cada control, junto con su puntaje correspondiente.
        $sintomasPorControl = [];
        if (!empty($controles)) {
            $filas_sintomas = $this->controlSintomasModel
                ->select('control_sintomas.id_control, control_sintomas.id_sintoma, control_sintomas.valor_registrado, sintomas.nombre_sintoma')
                ->join('sintomas', 'sintomas.id = control_sintomas.id_sintoma')
                ->whereIn('control_sintomas.id_control', array_column($controles, 'id'))
                ->where('sintomas.fecha_borrado', null)
                ->orderBy('control_sintomas.id_control', 'ASC')
                ->orderBy('control_sintomas.id_sintoma', 'ASC')
                ->findAll();

            foreach ($filas_sintomas as $fila) {
                $idControl = (int) $fila['id_control'];
                $idSintoma = (int) $fila['id_sintoma'];
                $valor = $fila['valor_registrado'];
                $puntos = 0;

                if (!in_array($idSintoma, [6, 7, 14, 15], true)) {
                    if (is_numeric($valor)) {
                        $valorSintoma = $this->valoresSintomasModel
                            ->where('id_sintoma', $idSintoma)
                            ->where('valor_min IS NOT NULL')
                            ->where('valor_min <=', $valor)
                            ->where('valor_max >=', $valor)
                            ->first();

                        if (!$valorSintoma) {
                            $valorSintoma = $this->valoresSintomasModel
                                ->where('id_sintoma', $idSintoma)
                                ->where('valor_min IS NOT NULL')
                                ->where('valor_min <=', $valor)
                                ->orderBy('valor_min', 'DESC')
                                ->first();
                        }
                    } else {
                        $valorSintoma = $this->valoresSintomasModel
                            ->where('id_sintoma', $idSintoma)
                            ->where('valor_texto', $valor)
                            ->first();
                    }

                    if ($valorSintoma) {
                        $puntos = (int) $valorSintoma['puntos'];
                    }
                }

                $sintomasPorControl[$idControl][] = [
                    'nombre' => $fila['nombre_sintoma'],
                    'valor' => $valor,
                    'puntos' => $puntos,
                ];
            }
        }

        // Medicaciones de cada control: [id_control => ['Salbutamol (4 puffs)', ...]]
        $medicacionesPorControl = [];
        if (!empty($controles)) {
            $filas_medicacion = $this->controlMedicacionModel
                ->select('control_medicaciones.id_control, control_medicaciones.dosis, medicaciones.nombre')
                ->join('medicaciones', 'medicaciones.id = control_medicaciones.id_medicacion')
                ->whereIn('control_medicaciones.id_control', array_column($controles, 'id'))
                ->orderBy('control_medicaciones.id')
                ->findAll();

            foreach ($filas_medicacion as $fila) {
                $medicacionesPorControl[$fila['id_control']][] = $fila['nombre'] . ' (' . $fila['dosis'] . ')';
            }
        }

        $factoresRegistrados = $this->pacienteFactoresModel->where('id_visita', $id_visita)->findAll();
        $todosLosFactores = $this->factoresModel->findAll();

        $paciente = $this->pacienteModel->find($visita['id_paciente']);

        $datos = [
            'titulo' => 'Detalle de Visita e Historial de Controles',
            'visita' => $visita,
            'paciente' => $paciente,
            'tutor' => $paciente ? $this->tutorModel->find($paciente['id_tutor']) : null,
            'usuario' => $this->usuarioModel->find($visita['id_usuario']),
            'controles' => $controles,
            'medicacionesPorControl' => $medicacionesPorControl,
            'sintomasPorControl' => $sintomasPorControl,
            'factoresRegistrados' => $factoresRegistrados,
            'todosLosFactores' => $todosLosFactores,
            'establecimientos' => $this->establecimientoModel->findAll()
        ];

        echo view('templates/header', $datos);
        echo view('visitas/ver', $datos);
        echo view('templates/footer');
    }
}