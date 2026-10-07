<?php
namespace App\Controllers;

use App\Models\PacienteModel;
use App\Models\TutorModel; 
use App\Models\EstablecimientosModel;

class Paciente extends BaseController
{
    protected $pacienteModel;
    protected $tutorModel;  
    protected $establecimientosModel;

    public function __construct()
    {
        $this->pacienteModel = new PacienteModel();
        $this->tutorModel = new TutorModel(); 
        $this->establecimientosModel = new EstablecimientosModel();
        helper('form');
    }

    public function index()
    {
        $datos = [
            'pacientes' => $this->pacienteModel->findAll(),
            'tutores' => $this->tutorModel->findAll(),
            'establecimientos' =>$this ->establecimientosModel ->findAll(),
            'titulo'    => 'Listado de Pacientes'
        ];
        
        echo view('templates/header', $datos);
        echo view('paciente/listadopaciente', $datos);
        echo view('templates/footer');
    }

    public function editar($id)
    {
        $datos = [
            'paciente' => $this->pacienteModel->where('id', $id)->first(),
            'tutores'  => $this->tutorModel->findAll(), 
            'establecimientos' =>$this ->establecimientosModel ->findAll(),
            'titulo'   => 'Editar Paciente'
        ];
        
        echo view('templates/header', $datos);
        echo view('paciente/editar', $datos);
        echo view('templates/footer');
    }

public function actualizar()
    {
        $id = $this->request->getPost('id');

        $reglas = [
            'dni'                         => 'required|numeric|min_length[7]|max_length[9]|is_unique[pacientes.dni,id,'.$id.']',
            'nombre'                      => 'required|min_length[3]|max_length[100]',
            'fecha_nacimiento'            => 'required|valid_date',
            'id_tutor'                    => 'required',
            'domicilio'                   => 'required|min_length[3]',
            'barrio'                      => 'required|min_length[3]',
            'id_area_programatica'        => 'required',
            'id_establecimiento_habitual' => 'required'
        ];

        $mensajes = [
            'dni' => [
                'required'   => 'El DNI es obligatorio.',
                'numeric'    => 'El DNI solo deben ser números.',
                'min_length' => 'El DNI ingresado es demasiado corto.',
                'max_length' => 'El DNI ingresado es demasiado largo.',
                'is_unique'  => 'Este DNI ya pertenece a otro paciente registrado.'
            ],
            'nombre' => [
                'required'   => 'El nombre completo es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.'
            ],
            'fecha_nacimiento' => [
                'required'   => 'La fecha de nacimiento es obligatoria.',
                'valid_date' => 'Debe ingresar una fecha válida.'
            ],
            'id_tutor' => [
                'required' => 'Debe seleccionar un tutor o responsable.'
            ],
            'domicilio' => [
                'required'   => 'El domicilio es obligatorio.',
                'min_length' => 'El domicilio debe ser más específico.'
            ],
            'barrio' => [
                'required'   => 'El barrio es obligatorio.',
                'min_length' => 'El nombre del barrio debe tener al menos 3 caracteres.'
            ],
            'id_area_programatica' => [
                'required' => 'Debe asignar un área programática.'
            ],
            'id_establecimiento_habitual' => [
                'required' => 'Debe seleccionar el establecimiento habitual.'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $this->pacienteModel->update($id, [
            'dni'                         => trim($this->request->getPost('dni')),
            'nombre'                      => trim($this->request->getPost('nombre')),
            'fecha_nacimiento'            => $this->request->getPost('fecha_nacimiento'),
            'id_tutor'                    => $this->request->getPost('id_tutor'),
            'domicilio'                   => trim($this->request->getPost('domicilio')),
            'barrio'                      => trim($this->request->getPost('barrio')),
            'id_area_programatica'        => $this->request->getPost('id_area_programatica'),
            'id_establecimiento_habitual' => $this->request->getPost('id_establecimiento_habitual')
        ]);
        
        return redirect()->to(base_url('paciente'))->with('exito', 'Paciente actualizado correctamente.');
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
        
        return redirect()->to(base_url('paciente'))->with('exito', 'Paciente recuperado correctamente.');
    }
}