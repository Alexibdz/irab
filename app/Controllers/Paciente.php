<?php
namespace App\Controllers;
use App\Models\PacienteModel;

class Paciente extends BaseController
{
    protected $pacienteModel;

    public function __construct()
    {
        $this->pacienteModel = new PacienteModel();
    }

    public function index()
    {
        $datos['pacientes'] = $this->pacienteModel->findAll();
        return view('paciente/listadopaciente', $datos);
    }

    public function nuevo()
    {
        return view('paciente/nuevo');
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
        // el unico con su id, por eso el first
        $datos['paciente'] = $this->pacienteModel->where('id', $id)->first();
        
        return view('paciente/editar', $datos);
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
        // borrado lógico
        $this->pacienteModel->delete($id);
        
        // la vista de aviso en lugar de redirigir
        return view('paciente/avisoborrado');
    }

    public function eliminados()
    {
        // onlyDeleted() trae solo los registros que tienen fecha de borrado
        $datos['pacientes'] = $this->pacienteModel->onlyDeleted()->findAll();
        
        return view('paciente/eliminados', $datos);
    }

    public function recuperar($id)
    {
        // Restauramos el paciente limpiando la fecha de borrado
        $this->pacienteModel->update($id, ['fecha_borrado' => null]);
        
        return redirect()->to(base_url('paciente'));
    }
}