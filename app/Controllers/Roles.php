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

        echo view('header');
        echo view('roles/listado', $datos);
        echo view('footer');
    }

    public function nuevo()
    {
        $datos = [
            "titulo" => "Nuevo Rol"
        ];

        echo view('header');
        echo view('roles/nuevo', $datos);
        echo view('footer');
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

        echo view('header');
        echo view('roles/editar', $datos);
        echo view('footer');
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

        echo view('header');
        echo view('roles/ver', $datos);
        echo view('footer');
    }

    /*public function borrar($id)
    {
        $this->rol->delete($id);

        return redirect()->to(base_url('roles'));
    }*/
}