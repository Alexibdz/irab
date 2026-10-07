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
        // carga el asistente de formularios de CodeIgniter
        helper('form');
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

        echo view('templates/header');
        echo view('usuarios/listado', $datos);
        echo view('templates/footer');
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

        echo view('templates/header');
        echo view('usuarios/nuevo', $datos);
        echo view('templates/footer');
    }

    // public function insertar()
    // {
    //     $datos = [
    //         "nombre" => $this->request->getPost('nombre'),
    //         "username" => $this->request->getPost('username'),
    //         "password" => password_hash( $this->request->getPost('password'), PASSWORD_DEFAULT ),
    //         "id_rol" => $this->request->getPost('id_rol'),
    //         "id_establecimiento_asignado" => $this->request->getPost('id_establecimiento_asignado')
    //     ];

    //     $this->usuarios->save($datos);

    //     return redirect()->to(base_url('configuracion/usuarios'))->with('exito', 'Usuario creado correctamente.');
    // }
    public function insertar()
    {
        // definimos eglas de validación
        $reglas = [
            'nombre'                      => 'required|min_length[3]|max_length[100]',
            'username'                    => 'required|min_length[3]|max_length[50]',
            'password'                    => 'required|min_length[8]|regex_match[/[#!*@$%&?¿]/]',
            'id_rol'                      => 'required',
            'id_establecimiento_asignado' => 'required'
        ];
        //traduccion de msj porque sino los muestra en ingles
        $mensajes = [
            'nombre' => [
                'required'   => 'El campo Nombre es obligatorio.',
                'min_length' => 'El Nombre debe tener al menos 3 caracteres.'
            ],
            'username' => [
                'required'   => 'El nombre de Usuario es obligatorio.',
                'min_length' => 'El Usuario debe tener al menos 3 caracteres.'
            ],
            'password' => [
                'required'    => 'La contraseña es obligatoria.',
                'min_length'  => 'La contraseña debe tener al menos 8 caracteres.',
                'regex_match' => 'La contraseña debe tener al menos un carácter especial (ej: #!*@$%&?¿).'
            ],
            'id_rol' => [
                'required' => 'Debes seleccionar un Rol.'
            ],
            'id_establecimiento_asignado' => [
                'required' => 'Debes asignar un Establecimiento.'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // pasamos a minusculas y eliminamos espacios en blanco del nombre de usuario
        $username = strtolower(trim($this->request->getPost('username')));

        // se verifica si el nombre de usuario ya existe, incluyendo los eliminados
        $usuarioExistente = $this->usuarios->where('username', $username)->withDeleted()->first();
        
        if ($usuarioExistente) {
            $errorMsg = empty($usuarioExistente['fecha_borrado']) 
                ? 'El nombre de usuario ya está en uso.' 
                : 'El usuario existe en la papelera. Por favor, recupérelo.';
            
            return redirect()->back()->withInput()->with('errors', ['username' => $errorMsg]);
        }

        // guardamos en la bbdd
        $datos = [
            "nombre"                      => trim($this->request->getPost('nombre')),
            "username"                    => $username,
            "password"                    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            "id_rol"                      => $this->request->getPost('id_rol'),
            "id_establecimiento_asignado" => $this->request->getPost('id_establecimiento_asignado')
        ];

        $this->usuarios->save($datos);

        return redirect()->to(base_url('configuracion/usuarios'))->with('exito', 'Usuario creado correctamente.');
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

        echo view('templates/header');
        echo view('usuarios/editar', $datos);
        echo view('templates/footer');
    }

    // public function actualizar()
    // {
    //     $id = $this->request->getPost('id');

    //     $datos = [
    //         "nombre" => $this->request->getPost('nombre'),
    //         "username" => $this->request->getPost('username'),
    //         "id_rol" => $this->request->getPost('id_rol'),
    //         "id_establecimiento_asignado" => $this->request->getPost('id_establecimiento_asignado')
    //     ];

    //     $password = $this->request->getPost('password');

    //     if ($password != '') {
    //         $datos["password"] = password_hash( $password, PASSWORD_DEFAULT );
    //     }

    //     $this->usuarios->update($id, $datos);

    //     return redirect()->to(base_url('configuracion/usuarios'))->with('exito', 'Usuario actualizado correctamente.');
    // }
    public function actualizar()
    {
        $id = $this->request->getPost('id');

        // el permit_empty en password permite que el campo de contraseña sea opcional durante la actualización. Si el usuario no ingresa una nueva contraseña, no se actualizará.
        $reglas = [
            'nombre'                      => 'required|min_length[3]|max_length[100]',
            'username'                    => 'required|min_length[3]|max_length[50]',
            'password'                    => 'permit_empty|min_length[8]|regex_match[/[#!*@$%&?¿]/]',
            'id_rol'                      => 'required',
            'id_establecimiento_asignado' => 'required'
        ];

        $mensajes = [
            'nombre' => [
                'required'   => 'El campo Nombre es obligatorio.',
                'min_length' => 'El Nombre debe tener al menos 3 caracteres.'
            ],
            'username' => [
                'required'   => 'El nombre de Usuario es obligatorio.',
                'min_length' => 'El Usuario debe tener al menos 3 caracteres.'
            ],
            'password' => [
                'required'    => 'La contraseña es obligatoria.',
                'min_length'  => 'La contraseña debe tener al menos 8 caracteres.',
                'regex_match' => 'La contraseña debe tener al menos un carácter especial (ej: #!*@$%&?¿).'
            ],
            'id_rol' => [
                'required' => 'Debes seleccionar un Rol.'
            ],
            'id_establecimiento_asignado' => [
                'required' => 'Debes asignar un Establecimiento.'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $username = strtolower(trim($this->request->getPost('username')));
        $usuarioExistente = $this->usuarios->where('username', $username)->where('id !=', $id)->withDeleted()->first();
        
        if ($usuarioExistente) {
            $errorMsg = empty($usuarioExistente['fecha_borrado']) 
                ? 'El nombre de usuario ya está en uso por otra persona.' 
                : 'Ese nombre de usuario existe en la papelera.';
            
            return redirect()->back()->withInput()->with('errors', ['username' => $errorMsg]);
        }

        //se prepara para act
        $datos = [
            "nombre"                      => trim($this->request->getPost('nombre')),
            "username"                    => $username,
            "id_rol"                      => $this->request->getPost('id_rol'),
            "id_establecimiento_asignado" => $this->request->getPost('id_establecimiento_asignado')
        ];

        // aca actualiza la contraseña solo si se escribió algo
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $datos["password"] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->usuarios->update($id, $datos);

        return redirect()->to(base_url('configuracion/usuarios'))->with('exito', 'Usuario actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $this->usuarios->delete($id);

        return redirect()->to(base_url('configuracion/usuarios'))->with('exito', 'Usuario eliminado correctamente.');
    }

    public function eliminados()
    {
        $datos = [
            'usuarios' => $this->usuarios->onlyDeleted()->findAll(),
            'titulo' => 'Usuarios Eliminados'
        ];

        echo view('templates/header', $datos);
        echo view('usuarios/eliminados', $datos);
        echo view('templates/footer');
    }

    public function recuperar($id)
    {
        $this->usuarios->update($id, ['fecha_borrado' => null]);
        return redirect()->to(base_url('configuracion/usuarios'))->with('exito', 'Usuario recuperado correctamente.');
    }
    
}