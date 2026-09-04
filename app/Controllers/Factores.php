<?php

namespace App\Controllers;

use App\Models\FactoresModel;
use App\Models\ValoresFactoresModel;

class Factores extends BaseController
{
    protected $factor;
    protected $valor;

    public function __construct()
    {
        $this->factor = new FactoresModel();
        $this->valor = new ValoresFactoresModel();
    }

    public function index()
    {
        $factores = $this->factor->findAll();

        $datos = [
            "factores" => $factores,
            "titulo" => "Factores"
        ];

        echo view('templates/header');
        echo view('factores/listado', $datos);
        echo view('templates/footer');
    }

    public function nuevo()
    {
        $datos = [
            "titulo" => "Nuevo Factor"
        ];

        echo view('templates/header');
        echo view('factores/nuevo', $datos);
        echo view('templates/footer');
    }

    public function insertar()
    {
        $datos = [
            "denominacion" => $this->request->getPost('denominacion'),
            "tipo" => $this->request->getPost('tipo'),
            "tipo_formulario" => $this->request->getPost('tipo_formulario')
        ];

        $this->factor->save($datos);

        return redirect()->to(base_url('factores'));
    }

    public function editar($id)
    {
        $factor = $this->factor->where('id', $id)->first();

        $datos = [
            "factor" => $factor,
            "valores" => $this->valor->where('id_factor', $id)->findAll(),
            "titulo" => "Editar Factor"
        ];

        echo view('templates/header');
        echo view('factores/editar', $datos);
        echo view('templates/footer');
    }

    public function actualizar()
    {
        $id = $this->request->getPost('id');

        $datos = [
            "denominacion" => $this->request->getPost('denominacion'),
            "tipo" => $this->request->getPost('tipo'),
            "tipo_formulario" => $this->request->getPost('tipo_formulario')
        ];

        $this->factor->update($id, $datos);

        return redirect()->to(base_url('factores'));
    }

    public function ver($id)
    {
        $factor = $this->factor->where('id', $id)->first();

        $datos = [
            "factor" => $factor,
            "valores" => $this->valor->where('id_factor', $id)->findAll(),
            "titulo" => "Ver Factor"
        ];

        echo view('templates/header');
        echo view('factores/ver', $datos);
        echo view('templates/footer');
    }

    public function eliminar($id)
    {
        $this->factor->delete($id);

        return redirect()->to(base_url('factores'));
    }

    public function eliminados()
    {
        $datos = [
            'factores' => $this->factor->onlyDeleted()->findAll(),
            'titulo' => 'Factores Eliminados'
        ];

        echo view('templates/header', $datos);
        echo view('factores/eliminados', $datos);
        echo view('templates/footer');
    }

    public function recuperar($id)
    {
        $this->factor->update($id, ['fecha_borrado' => null]);
        return redirect()->to(base_url('factores'));
    }
}
