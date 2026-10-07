<?php

/*
 * app/Helpers/permisos_helper.php
 *
 * Agregar "permisos" en:
 *
 * app/Config/Autoload.php
 *
 * public $helpers = ['edad', 'permisos'];
 */


/*
 * Devuelve los módulos disponibles.
 *
 * La clave es el nombre que se guarda en la base de datos.
 * El valor es el nombre que se muestra al usuario.
 */
if (!function_exists('modulos_disponibles')) {

    function modulos_disponibles(): array
    {
        return [
            'visitas' => 'Visitas',
            'pacientes' => 'Pacientes',
            'tutores' => 'Tutores',
            'usuarios' => 'Usuarios',
            'establecimientos' => 'Establecimientos',
            'permisos' => 'Permisos',
            'factores' => 'Factores',
            'sintomas' => 'Síntomas',
            'copia-seguridad' => 'Copia de seguridad'
        ];
    }
}


/*
 * Comprueba si el usuario tiene permiso
 * para realizar una acción en un módulo.
 *
 * Ejemplo:
 *
 * puede('pacientes', 'crear')
 *
 * devuelve:
 * true  -> tiene permiso
 * false -> no tiene permiso
 */
if (!function_exists('puede')) {

    function puede(string $modulo, string $accion = 'ver'): bool
    {
        // Obtenemos el rol del usuario logueado
        $idRol = session()->get('id_rol');

        // Si no tiene rol, no tiene permisos
        if (!$idRol) {
            return false;
        }

        /*
         * Buscamos los permisos del rol.
         */
        $permisos = db_connect()
            ->table('permisos')
            ->where('id_rol', $idRol)
            ->get()
            ->getResultArray();

        /*
         * Recorremos los permisos encontrados.
         */
        foreach ($permisos as $permiso) {

            // Buscamos el módulo solicitado
            if ($permiso['modulo'] == $modulo) {

                // Ejemplo:
                // puede_ver
                // puede_crear
                // puede_editar
                // puede_eliminar
                $campo = 'puede_' . $accion;

                return !empty($permiso[$campo]);
            }
        }

        // Si no encontramos el módulo, no tiene permiso
        return false;
    }
}