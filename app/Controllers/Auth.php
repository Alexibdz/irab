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
    // public function validarLogin()
    // {
    //     $username = $this->request->getPost('username');
    //     $password = $this->request->getPost('password');

    //     $usuario = $this->usuario->where('username', $username)->first();

    //     if ($usuario && password_verify($password, $usuario['password'])) {
    //         session()->set([
    //             'id_usuario'                  => $usuario['id'],
    //             'nombre'                      => $usuario['nombre'],
    //             'id_rol'                      => $usuario['id_rol'],
    //             'id_establecimiento_asignado' => $usuario['id_establecimiento_asignado'],
    //             'logueado'                    => true,
    //         ]);
    //         return redirect()->to(base_url('panel'));
    //     }
    //     return redirect()->to(base_url('login'))->with('error', 'Usuario o contraseña incorrectos.');
    // }
    public function validarLogin()
    {
        // le decimos reglas basicas de validacion (la longitud, que sea obligato)
        $reglas = [
            'username' => 'required|trim|min_length[3]|max_length[50]',
            'password' => 'required|trim|max_length[255]'
        ];

        if (!$this->validate($reglas)) {
            return $this->response->setJSON([
                'success' => false,
                'mensaje' => 'Por favor, completa los campos correctamente.',
                'token'   => csrf_hash() // aca enviamos un nuevo token de seguridad
            ]);
        }

        $username = $this->request->getPost('username');
        $password = (string) $this->request->getPost('password');
        $usuario = $this->usuario->where('username', $username)->first();

        // Verificamos si existe el usuario y la contraseña coincide
        if ($usuario && password_verify($password, $usuario['password'])) {
            session()->set([
                'id_usuario'                  => $usuario['id'],
                'nombre'                      => $usuario['nombre'],
                'id_rol'                      => $usuario['id_rol'],
                'id_establecimiento_asignado' => $usuario['id_establecimiento_asignado'],
                'logueado'                    => true,
            ]);
            //si es exitosa, se le da la bienvenida y deja que continue a la pagina principal 
            return $this->response->setJSON([
                'success'  => true,
                'mensaje'  => '¡Bienvenido!',
                'redirect' => base_url('panel')
            ]);
        }

        //si falla , se vuelve a enviar el formulario con un mensaje de error y un nuevo token de seguridad
        return $this->response->setJSON([
            'success' => false,
            'mensaje' => 'Usuario o contraseña incorrectos.',
            'token'   => csrf_hash() // aca enviamos un nuevo token de seguridad
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}