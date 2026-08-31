<?php 
namespace App\Controllers;
use App\Models\RolesModel;
use App\Models\UsuariosModel;

class Auth extends BaseController
{
    protected $usuario;
    protected $rol;
    public function __construct()
    {
        $this->usuario = new UsuariosModel();
        $this->rol     = new RolesModel();
    }
    public function index()
    {
        //echo view('header');
        echo view('login/login');
        //echo view('footer');
    }
    public function validarLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $usuario = $this->usuario->where('username', $username)->first();

        if ($usuario && password_verify($password, $usuario['password'])) {
            session()->set([
                'id_usuario'                  => $usuario['id'],
                'nombre'                      => $usuario['nombre'],
                'id_rol'                      => $usuario['id_rol'],
                'id_establecimiento_asignado' => $usuario['id_establecimiento_asignado'],
                'logueado'                    => true,
            ]);
            return redirect()->to(base_url('panel'));
        }
        return redirect()->to(base_url('login'))->with('error', 'Usuario o contraseña incorrectos.');
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}