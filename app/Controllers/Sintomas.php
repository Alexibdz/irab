<?php

namespace App\Controllers;

use App\Models\SintomasModel;
use App\Models\ValoresSintomasModel;

class Sintomas extends BaseController
{
    protected $sintoma;
    protected $valor;

    public function __construct()
    {
        $this->sintoma = new SintomasModel();
        $this->valor = new ValoresSintomasModel();
        helper('form');
    }

    public function index()
    {
        $sintomas = $this->sintoma->findAll();

        $datos = [
            "sintomas" => $sintomas,
            "titulo" => "Sintomas"
        ];

        echo view('templates/header');
        echo view('sintomas/listado', $datos);
        echo view('templates/footer');
    }

    public function nuevo()
    {
        $datos = [
            "titulo" => "Nuevo Sintoma"
        ];

        echo view('templates/header');
        echo view('sintomas/nuevo', $datos);
        echo view('templates/footer');
    }

    public function insertar()
    {
        $reglas = [
            'nombre_sintoma'  => 'required|min_length[3]|max_length[100]',
            'tipo_formulario' => 'required'
        ];

        $mensajes = [
            'nombre_sintoma' => [
                'required'   => 'El nombre del síntoma es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre es demasiado largo.'
            ],
            'tipo_formulario' => [
                'required' => 'Debes seleccionar el tipo de formulario.'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            "nombre_sintoma"  => trim($this->request->getPost('nombre_sintoma')),
            "tipo_formulario" => $this->request->getPost('tipo_formulario')
        ];

        $this->sintoma->save($datos);

        return redirect()->to(base_url('configuracion/sintomas'))->with('exito', 'Sintoma creado correctamente.');
    }

    public function editar($id)
    {
        $sintoma = $this->sintoma->where('id', $id)->first();

        $datos = [
            "sintoma" => $sintoma,
            "valores" => $this->valor->where('id_sintoma', $id)->findAll(),
            "titulo" => "Editar Sintoma"
        ];

        echo view('templates/header');
        echo view('sintomas/editar', $datos);
        echo view('templates/footer');
    }

public function actualizar()
    {
        $id = $this->request->getPost('id');

        $reglas = [
            'nombre_sintoma'  => 'required|min_length[3]|max_length[100]',
            'tipo_formulario' => 'required'
        ];

        $mensajes = [
            'nombre_sintoma' => [
                'required'   => 'El nombre del síntoma es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre es demasiado largo.'
            ],
            'tipo_formulario' => [
                'required' => 'Debes seleccionar el tipo de formulario.'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            "nombre_sintoma"  => trim($this->request->getPost('nombre_sintoma')),
            "tipo_formulario" => $this->request->getPost('tipo_formulario')
        ];

        $this->sintoma->update($id, $datos);

        return redirect()->to(base_url('configuracion/sintomas'))->with('exito', 'Sintoma actualizado correctamente.');
    }

    public function ver($id)
    {
        $sintoma = $this->sintoma->where('id', $id)->first();

        $datos = [
            "sintoma" => $sintoma,
            "valores" => $this->valor->where('id_sintoma', $id)->findAll(),
            "titulo" => "Ver Sintoma"
        ];

        echo view('templates/header');
        echo view('sintomas/ver', $datos);
        echo view('templates/footer');
    }

    public function eliminar($id)
    {
        $this->sintoma->delete($id);

        return redirect()->to(base_url('configuracion/sintomas'))->with('exito', 'Sintoma eliminado correctamente.');
    }

    public function eliminados()
    {
        $datos = [
            'sintomas' => $this->sintoma->onlyDeleted()->findAll(),
            'titulo' => 'Sintomas Eliminados'
        ];

        echo view('templates/header', $datos);
        echo view('sintomas/eliminados', $datos);
        echo view('templates/footer');
    }

    public function recuperar($id)
    {
        $this->sintoma->update($id, ['fecha_borrado' => null]);
        return redirect()->to(base_url('configuracion/sintomas'))->with('exito', 'Sintoma recuperado correctamente.');
    }
}
