<?php

namespace App\Controllers;

use App\Models\SintomasModel;
use App\Models\ValoresSintomasModel;

class ValoresSintomas extends BaseController
{
    protected $valor;
    protected $sintoma;

    public function __construct()
    {
        $this->valor = new ValoresSintomasModel();
        $this->sintoma = new SintomasModel();
    }

    public function index($idSintoma)
    {
        $datos = [
            "sintoma" => $this->sintoma->find($idSintoma),
            "valores" => $this->valor->where('id_sintoma', $idSintoma)->findAll(),
            "titulo" => "Valores del Sintoma"
        ];

        echo view('templates/header');
        echo view('valores_sintomas/listado', $datos);
        echo view('templates/footer');
    }

    public function nuevo($idSintoma)
    {
        $datos = [
            "sintoma" => $this->sintoma->find($idSintoma),
            "titulo" => "Nuevo Valor de Sintoma"
        ];

        echo view('templates/header');
        echo view('valores_sintomas/nuevo', $datos);
        echo view('templates/footer');
    }

    public function insertar()
    {
        $idSintoma = $this->request->getPost('id_sintoma');

        $datos = [
            "id_sintoma" => $idSintoma,
            "valor_min" => $this->request->getPost('valor_min') ?: null,
            "valor_max" => $this->request->getPost('valor_max') ?: null,
            "valor_texto" => $this->request->getPost('valor_texto') ?: null,
            "puntos" => $this->request->getPost('puntos')
        ];

        $this->valor->save($datos);

        return redirect()->to(base_url('sintomas/valores/'.$idSintoma));
    }

    public function editar($id)
    {
        $valor = $this->valor->where('id', $id)->first();

        $datos = [
            "valor" => $valor,
            "sintoma" => $this->sintoma->find($valor['id_sintoma']),
            "titulo" => "Editar Valor de Sintoma"
        ];

        echo view('templates/header');
        echo view('valores_sintomas/editar', $datos);
        echo view('templates/footer');
    }

    public function actualizar()
    {
        $id = $this->request->getPost('id');
        $idSintoma = $this->request->getPost('id_sintoma');

        $datos = [
            "valor_min" => $this->request->getPost('valor_min') ?: null,
            "valor_max" => $this->request->getPost('valor_max') ?: null,
            "valor_texto" => $this->request->getPost('valor_texto') ?: null,
            "puntos" => $this->request->getPost('puntos')
        ];

        $this->valor->update($id, $datos);

        return redirect()->to(base_url('sintomas/valores/'.$idSintoma));
    }

    public function eliminar($id)
    {
        $valor = $this->valor->where('id', $id)->first();
        $idSintoma = $valor['id_sintoma'];

        $this->valor->delete($id);

        return redirect()->to(base_url('sintomas/valores/'.$idSintoma));
    }
}
