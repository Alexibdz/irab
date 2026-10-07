<?php

namespace App\Controllers;

use App\Models\EstablecimientosModel;

class Establecimientos extends BaseController
{
    protected $establecimiento;

    public function __construct()
    {
        $this->establecimiento = new EstablecimientosModel();
        // Cargamos el helper de formularios para prevenir errores en las vistas
        helper('form');
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
        // reglas
        $reglas = [
            'nombre'  => 'required|min_length[3]|max_length[100]',
            'cuartel' => 'required',
            'tipo'    => 'required'
        ];

        $mensajes = [
            'nombre' => [
                'required'   => 'El nombre del establecimiento es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre es demasiado largo.'
            ],
            'cuartel' => [
                'required' => 'Debes seleccionar un cuartel.'
            ],
            'tipo' => [
                'required' => 'Debes seleccionar el tipo de establecimiento.'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            "nombre"  => trim($this->request->getPost('nombre')),
            "cuartel" => $this->request->getPost('cuartel'),
            "tipo"    => $this->request->getPost('tipo')
        ];

        $this->establecimiento->save($datos);

        return redirect()->to(base_url('configuracion/establecimientos'))->with('exito', 'Establecimiento creado correctamente.');
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

        $reglas = [
            'nombre'  => 'required|min_length[3]|max_length[100]',
            'cuartel' => 'required',
            'tipo'    => 'required'
        ];

        $mensajes = [
            'nombre' => [
                'required'   => 'El nombre del establecimiento es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre es demasiado largo.'
            ],
            'cuartel' => [
                'required' => 'Debes seleccionar un cuartel.'
            ],
            'tipo' => [
                'required' => 'Debes seleccionar el tipo de establecimiento.'
            ]
        ];

        // hace la validación
        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            "nombre"  => trim($this->request->getPost('nombre')),
            "cuartel" => $this->request->getPost('cuartel'),
            "tipo"    => $this->request->getPost('tipo')
        ];

        $this->establecimiento->update($id, $datos);

        return redirect()->to(base_url('configuracion/establecimientos'))->with('exito', 'Establecimiento actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $this->establecimiento->delete($id);

        return redirect()->to(base_url('configuracion/establecimientos'))->with('exito', 'Establecimiento eliminado correctamente.');
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
        return redirect()->to(base_url('configuracion/establecimientos'))->with('exito', 'Establecimiento recuperado correctamente.');
    }
}