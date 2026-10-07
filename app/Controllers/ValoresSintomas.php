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
        helper('form');
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

        $reglas = [
            'puntos'      => 'required|numeric',
            'valor_min'   => 'permit_empty|numeric',
            'valor_max'   => 'permit_empty|numeric'
        ];

        $mensajes = [
            'puntos' => [
                'required' => 'El campo puntos es obligatorio.',
                'numeric'  => 'Los puntos deben ser un número.'
            ],
            'valor_min' => [
                'numeric'  => 'El valor mínimo debe ser numérico.'
            ],
            'valor_max' => [
                'numeric'  => 'El valor máximo debe ser numérico.'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            "id_sintoma"  => $idSintoma,
            "valor_min"   => trim($this->request->getPost('valor_min')) ?: null,
            "valor_max"   => trim($this->request->getPost('valor_max')) ?: null,
            "valor_texto" => trim($this->request->getPost('valor_texto')) ?: null,
            "puntos"      => trim($this->request->getPost('puntos'))
        ];

        $this->valor->save($datos);

        return redirect()->to(base_url('configuracion/sintomas/valores/'.$idSintoma))->with('exito', 'Valor creado correctamente.');
    }

    public function actualizar()
    {
        $id = $this->request->getPost('id');
        $idSintoma = $this->request->getPost('id_sintoma');

        $reglas = [
            'puntos'      => 'required|numeric',
            'valor_min'   => 'permit_empty|numeric',
            'valor_max'   => 'permit_empty|numeric'
        ];

        $mensajes = [
            'puntos' => [
                'required' => 'El campo puntos es obligatorio.',
                'numeric'  => 'Los puntos deben ser un número.'
            ],
            'valor_min' => [
                'numeric'  => 'El valor mínimo debe ser numérico.'
            ],
            'valor_max' => [
                'numeric'  => 'El valor máximo debe ser numérico.'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            "valor_min"   => trim($this->request->getPost('valor_min')) ?: null,
            "valor_max"   => trim($this->request->getPost('valor_max')) ?: null,
            "valor_texto" => trim($this->request->getPost('valor_texto')) ?: null,
            "puntos"      => trim($this->request->getPost('puntos'))
        ];

        $this->valor->update($id, $datos);

        return redirect()->to(base_url('configuracion/sintomas/valores/'.$idSintoma))->with('exito', 'Valor actualizado correctamente.');
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

    public function eliminar($id)
    {
        $valor = $this->valor->where('id', $id)->first();
        $idSintoma = $valor['id_sintoma'];

        $this->valor->delete($id);

        return redirect()->to(base_url('configuracion/sintomas/valores/'.$idSintoma))->with('exito', 'Valor eliminado correctamente.');
    }
}
