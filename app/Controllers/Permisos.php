<?php

namespace App\Controllers;

use App\Models\PermisoModel;
use App\Models\RolesModel;

class Permisos extends BaseController
{
    protected $permiso;
    protected $rol;

    public function __construct()
    {
        $this->permiso = new PermisoModel();
        $this->rol = new RolesModel();

        helper(['form', 'permisos']);
    }

    // Lista todos los roles
    public function index()
    {
        $datos = [
            'roles' => $this->rol->orderBy('nombre', 'ASC')->findAll(),
            'titulo' => 'Permisos por rol'
        ];

        echo view('templates/header');
        echo view('permisos/listado', $datos);
        echo view('templates/footer');
    }

    // Muestra los permisos de un rol
    public function editar($idRol)
    {
        $rol = $this->rol->find($idRol);

        if (!$rol) {
            return redirect()->to(base_url('configuracion/permisos'))
                ->with('error', 'Rol no encontrado.');
        }

        // Buscamos los permisos que ya tiene el rol
        $permisos = $this->permiso
            ->where('id_rol', $idRol)
            ->findAll();

        $actuales = [];

        foreach ($permisos as $permiso) {
            $actuales[$permiso['modulo']] = $permiso;
        }

        $datos = [
            'rol' => $rol,

            'modulos' => [
                'panel' => 'Panel',
                'pacientes' => 'Pacientes',
                'tutores' => 'Tutores',
                'visitas' => 'Visitas',
                'usuarios' => 'Usuarios',
                'establecimientos' => 'Establecimientos',
                'factores' => 'Factores',
                'sintomas' => 'Síntomas',
                'permisos' => 'Permisos'
            ],

            'actuales' => $actuales,

            'acciones' => [
                'ver' => 'Ver',
                'crear' => 'Crear',
                'editar' => 'Editar',
                'eliminar' => 'Eliminar'
            ],

            'titulo' => 'Permisos del rol'
        ];

        echo view('templates/header');
        echo view('permisos/editar', $datos);
        echo view('templates/footer');
    }

    // Guarda los permisos del rol
    public function actualizar()
    {
        $idRol = $this->request->getPost('id_rol');

        // Comprobamos que exista el rol
        if (!$this->rol->find($idRol)) {
            return redirect()->to(base_url('configuracion/permisos'))
                ->with('error', 'Rol no encontrado.');
        }

        /*
         * Los checkbox que no están marcados
         * no aparecen en el formulario enviado.
         */
        $permisosEnviados = $this->request->getPost('permisos') ?? [];

        $modulos = [
            'panel',
            'pacientes',
            'tutores',
            'visitas',
            'usuarios',
            'establecimientos',
            'factores',
            'sintomas',
            'permisos'
        ];

        $acciones = [
            'ver',
            'crear',
            'editar',
            'eliminar'
        ];

        $filas = [];

        foreach ($modulos as $modulo) {

            $fila = [
                'id_rol' => $idRol,
                'modulo' => $modulo
            ];

            foreach ($acciones as $accion) {

                if (isset($permisosEnviados[$modulo][$accion])) {
                    $fila['puede_' . $accion] = 1;
                } else {
                    $fila['puede_' . $accion] = 0;
                }
            }

            /*
             * El usuario no puede quitarse a sí mismo
             * el acceso a la pantalla de permisos.
             */
            if (
                $idRol == session()->get('id_rol')
                && $modulo == 'permisos'
            ) {
                $fila['puede_ver'] = 1;
                $fila['puede_editar'] = 1;
            }

            $filas[] = $fila;
        }

        // Guardamos todos los permisos
        $db = db_connect();

        $db->transStart();

        // Primero eliminamos los permisos anteriores
        $this->permiso
            ->where('id_rol', $idRol)
            ->delete();

        // Después insertamos los nuevos
        $this->permiso->insertBatch($filas);

        $db->transComplete();

        // Comprobamos si la operación fue correcta
        if (!$db->transStatus()) {
            return redirect()->back()
                ->with('error', 'No se pudieron guardar los permisos.');
        }

        return redirect()->to(base_url('configuracion/permisos'))
            ->with('exito', 'Permisos actualizados correctamente.');
    }
}