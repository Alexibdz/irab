<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Login
$routes->get('/login', 'Auth::index');
$routes->post('/validarLogin', 'Auth::validarLogin');
$routes->get('logout', 'Auth::logout');

// Rutas protegidas por autenticacion

$routes->group('', ['filter' => 'auth'], function ($routes) {

$routes->get('panel', 'Panel::index');

$routes->get ('usuarios' , 'Usuarios::index');
$routes->get ('usuarios/nuevo' , 'Usuarios::nuevo');
$routes->post ('usuarios/insertar' , 'Usuarios::insertar');
$routes->get('usuarios/editar/(:num)', 'Usuarios::editar/$1');
$routes->post('usuarios/actualizar', 'Usuarios::actualizar');
$routes->get('usuarios/ver/(:num)', 'Usuarios::ver/$1');
$routes->get('usuarios/eliminar/(:num)', 'Usuarios::eliminar/$1');
$routes->get('usuarios/eliminados', 'Usuarios::eliminados');
$routes->get('usuarios/recuperar/(:num)', 'Usuarios::recuperar/$1');


$routes->get('establecimientos', 'Establecimientos::index');
$routes->get('establecimientos/nuevo', 'Establecimientos::nuevo');
$routes->post('establecimientos/insertar', 'Establecimientos::insertar');
$routes->get('establecimientos/editar/(:num)', 'Establecimientos::editar/$1');
$routes->post('establecimientos/actualizar', 'Establecimientos::actualizar');
$routes->get('establecimientos/ver/(:num)', 'Establecimientos::ver/$1');
$routes->get('establecimientos/eliminar/(:num)', 'Establecimientos::eliminar/$1');
$routes->get('establecimientos/eliminados', 'Establecimientos::eliminados');
$routes->get('establecimientos/recuperar/(:num)', 'Establecimientos::recuperar/$1');

// Pacientes
$routes->get('paciente', 'Paciente::index');
$routes->get('paciente/editar/(:num)', 'Paciente::editar/$1');
$routes->post('paciente/actualizar', 'Paciente::actualizar');
$routes->get('paciente/borrar/(:num)', 'Paciente::borrar/$1');
$routes->get('paciente/eliminados', 'Paciente::eliminados');
$routes->get('paciente/recuperar/(:num)', 'Paciente::recuperar/$1');



// Tutores
$routes->get('tutor', 'Tutor::index');
$routes->get('tutor/editar/(:num)', 'Tutor::editar/$1');
$routes->post('tutor/actualizar/(:num)', 'Tutor::actualizar/$1');
$routes->get('tutor/borrar/(:num)', 'Tutor::borrar/$1');
$routes->get('tutor/eliminados', 'Tutor::eliminados');
$routes->get('tutor/recuperar/(:num)', 'Tutor::recuperar/$1');



$routes->get('factores', 'Factores::index');
$routes->get('factores/nuevo', 'Factores::nuevo');
$routes->post('factores/insertar', 'Factores::insertar');
$routes->get('factores/editar/(:num)', 'Factores::editar/$1');
$routes->post('factores/actualizar', 'Factores::actualizar');
$routes->get('factores/ver/(:num)', 'Factores::ver/$1');
$routes->get('factores/eliminar/(:num)', 'Factores::eliminar/$1');
$routes->get('factores/eliminados', 'Factores::eliminados');
$routes->get('factores/recuperar/(:num)', 'Factores::recuperar/$1');

$routes->get('factores/valores/nuevo/(:num)', 'ValoresFactores::nuevo/$1');
$routes->get('factores/valores/(:num)', 'ValoresFactores::index/$1');
$routes->post('valores-factores/insertar', 'ValoresFactores::insertar');
$routes->get('valores-factores/editar/(:num)', 'ValoresFactores::editar/$1');
$routes->post('valores-factores/actualizar', 'ValoresFactores::actualizar');
$routes->get('valores-factores/eliminar/(:num)', 'ValoresFactores::eliminar/$1');

$routes->get('sintomas', 'Sintomas::index');
$routes->get('sintomas/nuevo', 'Sintomas::nuevo');
$routes->post('sintomas/insertar', 'Sintomas::insertar');
$routes->get('sintomas/editar/(:num)', 'Sintomas::editar/$1');
$routes->post('sintomas/actualizar', 'Sintomas::actualizar');
$routes->get('sintomas/ver/(:num)', 'Sintomas::ver/$1');
$routes->get('sintomas/eliminar/(:num)', 'Sintomas::eliminar/$1');
$routes->get('sintomas/eliminados', 'Sintomas::eliminados');
$routes->get('sintomas/recuperar/(:num)', 'Sintomas::recuperar/$1');

$routes->get('sintomas/valores/nuevo/(:num)', 'ValoresSintomas::nuevo/$1');
$routes->get('sintomas/valores/(:num)', 'ValoresSintomas::index/$1');
$routes->post('valores-sintomas/insertar', 'ValoresSintomas::insertar');
$routes->get('valores-sintomas/editar/(:num)', 'ValoresSintomas::editar/$1');
$routes->post('valores-sintomas/actualizar', 'ValoresSintomas::actualizar');
$routes->get('valores-sintomas/eliminar/(:num)', 'ValoresSintomas::eliminar/$1');


//--------------------------visitas(Gaby) ----------------------------
$routes->get('visitas', 'Visita::index');
$routes->get('visitas/historial', 'Visita::historial');
// Alta de visita en dos pasos
$routes->get('visitas/crear', 'Visita::crear');
$routes->get('visitas/crear/(:num)', 'Visita::crear/$1');
$routes->get('visitas/buscar-tutor', 'Visita::buscarTutor');
$routes->post('visitas/paciente-nuevo', 'Visita::pacienteNuevo');
$routes->post('visitas/insertar', 'Visita::insertar');
$routes->get('visitas/editar/(:num)', 'Visita::editar/$1');
$routes->post('visitas/actualizar', 'Visita::actualizar');
$routes->get('visitas/ver/(:num)', 'Visita::ver/$1');
$routes->post('visitas/cerrar', 'Visita::cerrar');
$routes->get('visitas/reabrir/(:num)', 'Visita::reabrir/$1');
$routes->get('visitas/borrar/(:num)', 'Visita::borrar/$1');
$routes->get('visitas/eliminados', 'Visita::eliminados');
$routes->get('visitas/recuperar/(:num)', 'Visita::recuperar/$1');

// Controles
$routes->get('control/crear/(:num)', 'Control::crear/$1');
$routes->post('control/guardar', 'Control::guardar');



});

