<?php
namespace App\Controllers;

use App\Models\PacienteModel;
use App\Models\TutorModel; 

class Paciente extends BaseController
{
    protected $pacienteModel;
    protected $tutorModel; //agrego lo de tutor que no estaba 

    public function __construct()
    {
        $this->pacienteModel = new PacienteModel();
        $this->tutorModel = new TutorModel(); 
    }

    public function index()
    {
        $datos = [
            'pacientes' => $this->pacienteModel->findAll(),
            'titulo'    => 'Listado de Pacientes'
        ];
        
        echo view('templates/header', $datos);
        echo view('paciente/listadopaciente', $datos);
        echo view('templates/footer');
    }

    public function nuevo()
    {
        $datos = [
            'titulo'  => 'Registrar Paciente',
            'tutores' => $this->tutorModel->findAll() //  lista de tutores a la vista
        ];

        echo view('templates/header', $datos);
        echo view('paciente/nuevo', $datos);
        echo view('templates/footer');
    }

    public function insertar()
    {
        $datos = [
            'dni'                         => $this->request->getPost('dni'),
            'nombre'                      => $this->request->getPost('nombre'),
            'fecha_nacimiento'            => $this->request->getPost('fecha_nacimiento'),
            'id_tutor'                    => $this->request->getPost('id_tutor'),
            'id_establecimiento_habitual' => $this->request->getPost('id_establecimiento_habitual')
        ];

        $this->pacienteModel->insert($datos);
        return redirect()->to(base_url('paciente'));
    }

    public function editar($id)
    {
        $datos = [
            'paciente' => $this->pacienteModel->where('id', $id)->first(),
            'tutores'  => $this->tutorModel->findAll(), 
            'titulo'   => 'Editar Paciente'
        ];
        
        echo view('templates/header', $datos);
        echo view('paciente/editar', $datos);
        echo view('templates/footer');
    }

    public function actualizar()
    {
        $id = $this->request->getPost('id');

        $this->pacienteModel->update($id, [
            'dni'                         => $this->request->getPost('dni'),
            'nombre'                      => $this->request->getPost('nombre'),
            'fecha_nacimiento'            => $this->request->getPost('fecha_nacimiento'),
            'id_tutor'                    => $this->request->getPost('id_tutor'),
            'id_establecimiento_habitual' => $this->request->getPost('id_establecimiento_habitual')
        ]);
        
        return redirect()->to(base_url('paciente'));
    }

    public function borrar($id)
    {
        $this->pacienteModel->delete($id);
        
        $datos = ['titulo' => 'Paciente Eliminado'];
        
        echo view('templates/header', $datos);
        echo view('paciente/avisoborrado');
        echo view('templates/footer');
    }

    public function eliminados()
    {
        $datos = [
            'pacientes' => $this->pacienteModel->onlyDeleted()->findAll(),
            'titulo'    => 'Pacientes Eliminados'
        ];
        
        echo view('templates/header', $datos);
        echo view('paciente/eliminados', $datos);
        echo view('templates/footer');
    }

    public function recuperar($id)
    {
        $this->pacienteModel->update($id, ['fecha_borrado' => null]);
        
        return redirect()->to(base_url('paciente'));
    }
}