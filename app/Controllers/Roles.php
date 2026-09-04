<?php

namespace App\Controllers;

use App\Models\RolesModel;

class Roles extends BaseController
{
    protected $rol;

    public function __construct()
    {
        $this->rol = new RolesModel();
    }

    public function index()
    {
        $roles = $this->rol->findAll();

        $datos = [
            "roles" => $roles,
            "titulo" => "Roles"
        ];

        echo view('templates/header');
        echo view('roles/listado', $datos);
        echo view('templates/footer');
    }

    public function nuevo()
    {
        $datos = [
            "titulo" => "Nuevo Rol"
        ];

        echo view('templates/header');
        echo view('roles/nuevo', $datos);
        echo view('templates/footer');
    }

    public function insertar()
    {
        $datos = [
            "nombre" => $this->request->getPost('nombre')
        ];

        $this->rol->save($datos);

        return redirect()->to(base_url('roles'));
    }

    public function editar($id)
    {
        $rol = $this->rol->where('id', $id)->first();

        $datos = [
            "rol" => $rol,
            "titulo" => "Editar Rol"
        ];

        echo view('templates/header');
        echo view('roles/editar', $datos);
        echo view('templates/footer');
    }

    public function actualizar()
    {
        $id = $this->request->getPost('id');

        $datos = [
            "nombre" => $this->request->getPost('nombre')
        ];

        $this->rol->update($id, $datos);

        return redirect()->to(base_url('roles'));
    }

    public function ver($id)
    {
        $rol = $this->rol->where('id', $id)->first();

        $datos = [
            "rol" => $rol,
            "titulo" => "Ver Rol"
        ];

        echo view('templates/header');
        echo view('roles/ver', $datos);
        echo view('templates/footer');
    }

    public function eliminar($id)
    {
        $this->rol->delete($id);

        return redirect()->to(base_url('roles'));
    }
    public function eliminados()
    {
        $datos = [
            'roles' => $this->rol->onlyDeleted()->findAll(),
            'titulo' => 'Roles Eliminados'
        ];

        echo view('templates/header', $datos);
        echo view('roles/eliminados', $datos);
        echo view('templates/footer');
    }

    public function recuperar($id)
    {
        $this->rol->update($id, ['fecha_borrado' => null]);
        return redirect()->to(base_url('roles'));
    }
}