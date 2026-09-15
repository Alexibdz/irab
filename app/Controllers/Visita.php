<?php

namespace App\Controllers;

use App\Models\VisitaModel;
use App\Models\PacienteModel;
use App\Models\UsuariosModel;
use App\Models\EstablecimientosModel;

class Visita extends BaseController
{
    protected $visitaModel;
    protected $usuarioModel;
    protected $pacienteModel;
    protected $establecimientoModel;


    public function __construct()
    {
        $this->visitaModel = new VisitaModel();

        $this->pacienteModel = new PacienteModel();
        $this->usuarioModel = new UsuariosModel();
        $this->establecimientoModel = new EstablecimientosModel();
    }

    public function index()
    {
        $datos = ['visitas' => $this->visitaModel->findAll(),
            'pacientes' => $this->pacienteModel->findAll(),
            'usuarios' => $this->usuarioModel->findAll(),
            'establecimientos' => $this->establecimientoModel->findAll()];

        echo view('templates/header', $datos);
        echo view('visitas/index', $datos);
        echo view('templates/footer');
    }

    public function crear()
{
    $pacienteModel = new PacienteModel();
    $usuarioModel = new UsuariosModel();
    $establecimientoModel = new EstablecimientosModel();

    $datos = [
        'titulo' => 'Registrar visita',
        'pacientes' => $pacienteModel->findAll(),
        'usuarios' => $usuarioModel->findAll(),
        'establecimientos' => $establecimientoModel->findAll()
    ];

    echo view('templates/header', $datos);
    echo view('visitas/crear', $datos);
    echo view('templates/footer');
}
    public function insertar()
    {
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

        $this->visitaModel->insert($datos);

        return redirect()->to(base_url('visitas'));
    }

    public function editar($id)
    {
        //$pacienteModel = new PacienteModel();
        //$usuarioModel = new UsuariosModel();
        //$establecimientoModel = new EstablecimientosModel();

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
        //$visitas = $this->visitaModel
           // ->onlyDeleted()
            //->select('visitas.*, pacientes.nombre AS paciente, usuarios.nombre AS usuario, establecimientos_salud.nombre AS establecimiento')
            //->join('pacientes', 'pacientes.id = visitas.id_paciente', 'left')
            //->join('usuarios', 'usuarios.id = visitas.id_usuario', 'left')
            //->join('establecimientos_salud', 'establecimientos_salud.id = visitas.id_establecimiento', 'left')
            //->findAll();

        $datos = [
            'titulo' => 'Visitas eliminadas',
            'visitas' => $this->visitaModel->onlyDeleted()->findAll()
            //->select('visitas.*, pacientes.nombre AS paciente, usuarios.nombre AS usuario, establecimientos_salud.nombre AS establecimiento')
            //->join('pacientes', 'pacientes.id = visitas.id_paciente', 'left')
            //->join('usuarios', 'usuarios.id = visitas.id_usuario', 'left')
            //->join('establecimientos_salud', 'establecimientos_salud.id = visitas.id_establecimiento', 'left')
            
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

}