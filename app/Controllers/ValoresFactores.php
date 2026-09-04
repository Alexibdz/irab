<?php

namespace App\Controllers;

use App\Models\FactoresModel;
use App\Models\ValoresFactoresModel;

class ValoresFactores extends BaseController
{
    protected $valor;
    protected $factor;

    public function __construct()
    {
        $this->valor = new ValoresFactoresModel();
        $this->factor = new FactoresModel();
    }

    public function index($idFactor)
    {
        $datos = [
            "factor" => $this->factor->find($idFactor),
            "valores" => $this->valor->where('id_factor', $idFactor)->findAll(),
            "titulo" => "Valores del Factor"
        ];

        echo view('templates/header');
        echo view('valores_factores/listado', $datos);
        echo view('templates/footer');
    }

    public function nuevo($idFactor)
    {
        $datos = [
            "factor" => $this->factor->find($idFactor),
            "titulo" => "Nuevo Valor de Factor"
        ];

        echo view('templates/header');
        echo view('valores_factores/nuevo', $datos);
        echo view('templates/footer');
    }

    public function insertar()
    {
        $idFactor = $this->request->getPost('id_factor');

        $datos = [
            "id_factor" => $idFactor,
            "valor" => $this->request->getPost('valor')
        ];

        $this->valor->save($datos);

        return redirect()->to(base_url('factores/valores/'.$idFactor));
    }

    public function editar($id)
    {
        $valor = $this->valor->where('id', $id)->first();

        $datos = [
            "valor" => $valor,
            "factor" => $this->factor->find($valor['id_factor']),
            "titulo" => "Editar Valor de Factor"
        ];

        echo view('templates/header');
        echo view('valores_factores/editar', $datos);
        echo view('templates/footer');
    }

    public function actualizar()
    {
        $id = $this->request->getPost('id');
        $idFactor = $this->request->getPost('id_factor');

        $datos = [
            "valor" => $this->request->getPost('valor')
        ];

        $this->valor->update($id, $datos);

        return redirect()->to(base_url('factores/valores/'.$idFactor));
    }

    public function eliminar($id)
    {
        $valor = $this->valor->where('id', $id)->first();
        $idFactor = $valor['id_factor'];

        $this->valor->delete($id);

        return redirect()->to(base_url('factores/valores/'.$idFactor));
    }
}
