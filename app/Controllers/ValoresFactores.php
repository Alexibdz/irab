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
        helper('form');
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

        // 1. Reglas de validación
        $reglas = [
            'valor' => 'required'
        ];

        // 2. Mensajes en español
        $mensajes = [
            'valor' => [
                'required' => 'El campo valor es obligatorio.'
            ]
        ];

        // 3. Ejecutar validación
        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // 4. Sanitizar y guardar
        $datos = [
            "id_factor" => $idFactor,
            "valor"     => trim($this->request->getPost('valor'))
        ];

        $this->valor->save($datos);

        return redirect()->to(base_url('configuracion/factores/valores/'.$idFactor))->with('exito', 'Valor creado correctamente.');
    }

    public function actualizar()
    {
        $id = $this->request->getPost('id');
        $idFactor = $this->request->getPost('id_factor');

        $reglas = [
            'valor' => 'required'
        ];

        $mensajes = [
            'valor' => [
                'required' => 'El campo valor es obligatorio.'
            ]
        ];

        // 3. Ejecutar validación
        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            "valor" => trim($this->request->getPost('valor'))
        ];

        $this->valor->update($id, $datos);

        return redirect()->to(base_url('configuracion/factores/valores/'.$idFactor))->with('exito', 'Valor actualizado correctamente.');
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

    public function eliminar($id)
    {
        $valor = $this->valor->where('id', $id)->first();
        $idFactor = $valor['id_factor'];

        $this->valor->delete($id);

        return redirect()->to(base_url('configuracion/factores/valores/'.$idFactor))->with('exito', 'Valor eliminado correctamente.');
    }
}
