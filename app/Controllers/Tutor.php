<?php
namespace App\Controllers;
use App\Models\TutorModel;

class Tutor extends BaseController {
    protected $tutorModel;

    public function __construct() {
        $this->tutorModel = new TutorModel();
        helper('form');
    }

    public function index() {
        $datos = ['tutores' => $this->tutorModel->findAll(), 'titulo' => 'Listado de Tutores'];
        echo view('templates/header', $datos);
        echo view('tutor/listadotutor', $datos);
        echo view('templates/footer');
    }

    public function editar($id) {
        $datos = [
            'tutor'  => $this->tutorModel->where('id', $id)->first(),
            'titulo' => 'Editar Tutor'
        ];
        echo view('templates/header', $datos);
        echo view('tutor/editar', $datos);
        echo view('templates/footer');
    }

public function actualizar($id) {
        // reglas, el dni minimo 7, max 9 y numericos
        $reglas = [
            'dni'      => 'required|numeric|min_length[7]|max_length[9]|is_unique[tutores.dni,id,'.$id.']',
            'nombre'   => 'required|min_length[3]|max_length[100]',
            'telefono' => 'required|min_length[6]|max_length[20]'
        ];

        $mensajes = [
            'dni' => [
                'required'   => 'El DNI es obligatorio.',
                'numeric'    => 'El DNI solo debe contener números.',
                'min_length' => 'El DNI ingresado es demasiado corto.',
                'max_length' => 'El DNI ingresado es demasiado largo.',
                'is_unique'  => 'Este DNI ya está registrado para otro tutor en el sistema.'
            ],
            'nombre' => [
                'required'   => 'El nombre completo es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.'
            ],
            'telefono' => [
                'required'   => 'El teléfono es obligatorio.',
                'min_length' => 'El teléfono ingresado es muy corto.'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $this->tutorModel->update($id, [
            'dni'      => trim($this->request->getPost('dni')),
            'nombre'   => trim($this->request->getPost('nombre')),
            'telefono' => trim($this->request->getPost('telefono'))
        ]);
        
        return redirect()->to(base_url('tutor'))->with('exito', 'Tutor actualizado correctamente.');
    }
    public function borrar($id) {
        $this->tutorModel->delete($id);
        $datos = ['titulo' => 'Tutor Eliminado'];
        echo view('templates/header', $datos);
        echo view('tutor/avisoborrado');
        echo view('templates/footer');
    }

    public function eliminados() {
        $datos = [
            'tutores' => $this->tutorModel->onlyDeleted()->findAll(),
            'titulo'  => 'Tutores Eliminados'
        ];
        echo view('templates/header', $datos);
        echo view('tutor/eliminados', $datos);
        echo view('templates/footer');
    }

    public function recuperar($id) {
        $this->tutorModel->update($id, ['fecha_borrado' => null]);
        return redirect()->to(base_url('tutor'))->with('exito', 'Tutor recuperado correctamente.');
    }
}