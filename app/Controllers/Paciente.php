<?php
namespace App\Controllers;
use App\Models\PacienteModel;

class Paciente extends BaseController
{
    protected $pacienteModel;

    public function __construct()
    {
        // Instanciamos el modelo una sola vez
        $this->pacienteModel = new PacienteModel();
    }

    public function index()
    {
        // Usamos la propiedad protegida para buscar los datos
        $datos['pacientes'] = $this->pacienteModel->findAll();
        
        return view('paciente/listadopaciente', $datos);
    }

    //para crear nuevo paciente
    public function nuevo()
    {
        return view('paciente/nuevo');
    }

    //para guardar lo del formulario 
    public function insertar()
    {
        // por el getPost lo tomo del formulario y lo mando al array de datos
        $datos = [
            'dni'                         => $this->request->getPost('dni'),
            'nombre'                      => $this->request->getPost('nombre'),
            'fecha_nacimiento'            => $this->request->getPost('fecha_nacimiento'),
            'id_tutor'                    => $this->request->getPost('id_tutor'),
            'id_establecimiento_habitual' => $this->request->getPost('id_establecimiento_habitual')
        ];

        //  Pedimos al modelo protegido que inserte los datos
        $this->pacienteModel->insert($datos);

        // Redirigimos al usuario a la lista principal 
        return redirect()->to('/paciente');
    }
}