<?php
namespace App\Controllers;
use App\Models\TutorModel;

class Tutor extends BaseController {
    protected $tutorModel;

    public function __construct() {
        $this->tutorModel = new TutorModel();
    }

    public function index() {
        $datos = ['tutores' => $this->tutorModel->findAll(), 'titulo' => 'Listado de Tutores'];
        echo view('templates/header', $datos);
        echo view('tutor/listadotutor', $datos);
        echo view('templates/footer');
    }

    public function nuevo() {
        $datos = ['titulo' => 'Registrar Tutor'];
        echo view('templates/header', $datos);
        echo view('tutor/nuevo');
        echo view('templates/footer');
    }

    public function insertar() {
        $this->tutorModel->save([
            'dni'      => $this->request->getPost('dni'),
            'nombre'   => $this->request->getPost('nombre'),
            'telefono' => $this->request->getPost('telefono')
        ]);
        return redirect()->to(base_url('tutor'));
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
        $this->tutorModel->update($id, [
            'dni'      => $this->request->getPost('dni'),
            'nombre'   => $this->request->getPost('nombre'),
            'telefono' => $this->request->getPost('telefono')
        ]);
        return redirect()->to(base_url('tutor'));
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
        return redirect()->to(base_url('tutor'));
    }
}