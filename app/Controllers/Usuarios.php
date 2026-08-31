<?php

namespace App\Controllers;

use App\Models\UsuariosModel;
use App\Models\RolesModel;
use App\Models\EstablecimientosModel;

class Usuarios extends BaseController
{
    protected $usuarios;
    protected $rol;
    protected $establecimiento;

    public function __construct()
    {
        $this->usuarios = new UsuariosModel();
        $this->rol = new RolesModel();
        $this->establecimiento = new EstablecimientosModel();
    }

    public function index()
    {
        $usuarios = $this->usuarios
            ->select('usuarios.id, usuarios.nombre, usuarios.username, usuarios.id_rol, usuarios.id_establecimiento_asignado,
                    roles.nombre AS rol_nombre, establecimientos_salud.nombre AS establecimiento_nombre')
            ->join('roles', 'roles.id = usuarios.id_rol', 'left')
            ->join('establecimientos_salud', 'establecimientos_salud.id = usuarios.id_establecimiento_asignado', 'left')
            ->findAll();

        $datos = [
            "usuarios" => $usuarios,
            "titulo" => "Usuarios"
        ];

        echo view('header');
        echo view('usuarios/listado', $datos);
        echo view('footer');
    }

    public function nuevo()
    {
        $roles = $this->rol->findAll();
        $establecimientos = $this->establecimiento->findAll();

        $datos = [
            "roles" => $roles,
            "establecimientos" => $establecimientos,
            "titulo" => "Nuevo Usuario"
        ];

        echo view('header');
        echo view('usuarios/nuevo', $datos);
        echo view('footer');
    }

    public function insertar()
    {
        $datos = [
            "nombre" => $this->request->getPost('nombre'),
            "username" => $this->request->getPost('username'),
            "password" => password_hash( $this->request->getPost('password'), PASSWORD_DEFAULT ),
            "id_rol" => $this->request->getPost('id_rol'),
            "id_establecimiento_asignado" => $this->request->getPost('id_establecimiento_asignado')
        ];

        $this->usuarios->save($datos);

        return redirect()->to(base_url('usuarios'));
    }

    public function editar($id)
    {
        $usuario = $this->usuarios->where('id', $id)->first();
        $roles = $this->rol->findAll();
        $establecimientos = $this->establecimiento->findAll();

        $datos = [
            "usuario" => $usuario,
            "roles" => $roles,
            "establecimientos" => $establecimientos,
            "titulo" => "Editar Usuario"
        ];

        echo view('header');
        echo view('usuarios/editar', $datos);
        echo view('footer');
    }

    public function actualizar()
    {
        $id = $this->request->getPost('id');

        $datos = [
            "nombre" => $this->request->getPost('nombre'),
            "username" => $this->request->getPost('username'),
            "id_rol" => $this->request->getPost('id_rol'),
            "id_establecimiento_asignado" => $this->request->getPost('id_establecimiento_asignado')
        ];

        $password = $this->request->getPost('password');

        if ($password != '') {
            $datos["password"] = password_hash( $password, PASSWORD_DEFAULT );
        }

        $this->usuarios->update($id, $datos);

        return redirect()->to(base_url('usuarios'));
    }

    public function ver($id)
    {
        $usuario = $this->usuarios
            ->select('usuarios.id, usuarios.nombre, usuarios.username, usuarios.id_rol, usuarios.id_establecimiento_asignado, 
                    roles.nombre AS rol_nombre, establecimientos_salud.nombre AS establecimiento_nombre')
            ->join('roles', 'roles.id = usuarios.id_rol', 'left')
            ->join('establecimientos_salud', 'establecimientos_salud.id = usuarios.id_establecimiento_asignado','left')
            ->where('usuarios.id', $id)
            ->first();

        $datos = [
            "usuario" => $usuario,
            "titulo" => "Ver Usuario"
        ];

        echo view('header');
        echo view('usuarios/ver', $datos);
        echo view('footer');
    }

    /*public function borrar($id)
    {
        $this->usuarios->delete($id);

        return redirect()->to(base_url('usuarios'));
    }*/
}