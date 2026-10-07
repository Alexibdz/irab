<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PermisoFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('permiso');

        // Obtenemos las partes de la URL
        $segmentos = explode('/', trim(uri_string(), '/'));

        $primero = $segmentos[0] ?? '';

        /*
         * El panel y la pantalla principal de configuración
         * pueden ser vistos por cualquier usuario logueado.
         */
        if ($primero == 'panel') {
            return;
        }

        if ($primero == 'configuracion' && count($segmentos) == 1) {
            return;
        }

        /*
         * Obtenemos el módulo.
         *
         * Ejemplo:
         * pacientes/editar/5
         * módulo = pacientes
         *
         * configuracion/permisos/editar/3
         * módulo = permisos
         */
        if ($primero == 'configuracion') {
            $modulo = $segmentos[1] ?? '';
            $inicioAcciones = 2;
        } else {
            $modulo = $primero;
            $inicioAcciones = 1;
        }

        /*
         * Algunas URLs pertenecen a otro módulo.
         */
        $alias = [
            'valores-factores' => 'factores',
            'valores-sintomas' => 'sintomas',
            'control' => 'visitas',
            'paciente' => 'pacientes',
            'tutor' => 'tutores',
            'configuracion' => 'permisos'
        ];

        if (isset($alias[$modulo])) {
            $modulo = $alias[$modulo];
        }

        /*
         * Por defecto, solamente necesitamos permiso para VER.
         */
        $accion = 'ver';

        /*
         * Buscamos si la URL indica otra acción.
         */
        $acciones = [
            'nuevo' => 'crear',
            'crear' => 'crear',
            'insertar' => 'crear',
            'guardar' => 'crear',
            'paciente-nuevo' => 'crear',

            'editar' => 'editar',
            'actualizar' => 'editar',
            'cerrar' => 'editar',
            'reabrir' => 'editar',
            'recuperar' => 'editar',

            'eliminar' => 'eliminar',
            'borrar' => 'eliminar'
        ];

        for ($i = $inicioAcciones; $i < count($segmentos); $i++) {

            $segmento = $segmentos[$i];

            if (isset($acciones[$segmento])) {
                $accion = $acciones[$segmento];
                break;
            }
        }

        /*
         * Comprobamos si el usuario tiene permiso.
         */
        if (!puede($modulo, $accion)) {
            return redirect()
                ->to(base_url('panel'))
                ->with('error', 'No tienes permiso para realizar esta acción.');
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
    }
}