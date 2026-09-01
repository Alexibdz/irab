<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Login (sin filtro, tiene que ser accesible sin sesión)
$routes->get('/login', 'Auth::index');
$routes->post('/validarLogin', 'Auth::validarLogin');
$routes->get('logout', 'Auth::logout');

// Rutas protegidas por autenticación.
// Descomentar el grupo al finalizar el desarrollo o para probar el login.

$routes->group('', ['filter' => 'auth'], function ($routes) {

$routes->get('panel', 'Panel::index');

$routes->get('roles', 'Roles::index');
$routes->get('roles/nuevo', 'Roles::nuevo');
$routes->post('roles/insertar', 'Roles::insertar');
$routes->get('roles/editar/(:num)', 'Roles::editar/$1');
$routes->post('roles/actualizar', 'Roles::actualizar');
$routes->get('roles/ver/(:num)', 'Roles::ver/$1');
//$routes->get('roles/eliminar/(:num)', 'Roles::eliminar/$1');

$routes->get ('usuarios' , 'Usuarios::index');
$routes->get ('usuarios/nuevo' , 'Usuarios::nuevo');
$routes->post ('usuarios/insertar' , 'Usuarios::insertar');
$routes->get('usuarios/editar/(:num)', 'Usuarios::editar/$1');
$routes->post('usuarios/actualizar', 'Usuarios::actualizar');
$routes->get('usuarios/ver/(:num)', 'Usuarios::ver/$1');
//$routes->get('usuarios/eliminar/(:num)', 'Roles::eliminar/$1');

$routes->get('establecimientos', 'Establecimientos::index');
$routes->get('establecimientos/nuevo', 'Establecimientos::nuevo');
$routes->post('establecimientos/insertar', 'Establecimientos::insertar');
$routes->get('establecimientos/editar/(:num)', 'Establecimientos::editar/$1');
$routes->post('establecimientos/actualizar', 'Establecimientos::actualizar');
$routes->get('establecimientos/ver/(:num)', 'Establecimientos::ver/$1');
//$routes->get('establecimientos/borrar/(:num)', 'Establecimientos::borrar/$1');

});

//----------------------------- PACIENTE (por Lara)---------------------------
// lista de pacientes
$routes->get('paciente', 'Paciente::index');

// el formulario para registrar un nuevo paciente 
$routes->get('paciente/crear', 'Paciente::crear');

// recibe los datos del formulario 
$routes->post('paciente/guardar', 'Paciente::guardar');


//-----------------------------------------------------------------------