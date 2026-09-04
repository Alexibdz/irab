<?php

namespace App\Controllers;

use App\Models\EstablecimientosModel;

class Establecimientos extends BaseController
{
    protected $establecimiento;

    public function __construct()
    {
        $this->establecimiento = new EstablecimientosModel();
    }

    public function index()
    {
        $establecimientos = $this->establecimiento->findAll();

        $datos = [
            "establecimientos" => $establecimientos,
            "titulo" => "Establecimientos"
        ];

        echo view('templates/header');
        echo view('establecimientos/listado', $datos);
        echo view('templates/footer');
    }

    public function nuevo()
    {
        $datos = [
            "titulo" => "Nuevo Establecimiento"
        ];

        echo view('templates/header');
        echo view('establecimientos/nuevo', $datos);
        echo view('templates/footer');
    }

    public function insertar()
    {
        $datos = [
            "nombre" => $this->request->getPost('nombre'),
            "cuartel" => $this->request->getPost('cuartel'),
            "tipo" => $this->request->getPost('tipo')
        ];

        $this->establecimiento->save($datos);

        return redirect()->to(base_url('establecimientos'));
    }

    public function ver($id)
    {
        $establecimiento = $this->establecimiento->where('id', $id)->first();

        $datos = [
            "establecimiento" => $establecimiento,
            "titulo" => "Ver Establecimiento"
        ];

        echo view('templates/header');
        echo view('establecimientos/ver', $datos);
        echo view('templates/footer');
    }

    public function editar($id)
    {
        $establecimiento = $this->establecimiento->where('id', $id)->first();

        $datos = [
            "establecimiento" => $establecimiento,
            "titulo" => "Editar Establecimiento"
        ];

        echo view('templates/header');
        echo view('establecimientos/editar', $datos);
        echo view('templates/footer');
    }

    public function actualizar()
    {
        $id = $this->request->getPost('id');

        $datos = [
            "nombre" => $this->request->getPost('nombre'),
            "cuartel" => $this->request->getPost('cuartel'),
            "tipo" => $this->request->getPost('tipo')
        ];

        $this->establecimiento->update($id, $datos);

        return redirect()->to(base_url('establecimientos'));
    }

    public function eliminar($id)
    {
        $this->establecimiento->delete($id);

        return redirect()->to(base_url('establecimientos'));
    }
    public function eliminados()
    {
        $datos = [
            'establecimientos' => $this->establecimiento->onlyDeleted()->findAll(),
            'titulo' => 'Establecimientos Eliminados'
        ];

        echo view('templates/header', $datos);
        echo view('establecimientos/eliminados', $datos);
        echo view('templates/footer');
    }

    public function recuperar($id)
    {
        $this->establecimiento->update($id, ['fecha_borrado' => null]);
        return redirect()->to(base_url('establecimientos'));
    }
}