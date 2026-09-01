<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');


//----------------------------- PACIENTE (por Lara)---------------------------
// lista de pacientes
$routes->get('paciente', 'Paciente::index');

// el formulario para registrar un nuevo paciente 
$routes->get('paciente/crear', 'Paciente::crear');

// recibe los datos del formulario 
$routes->post('paciente/guardar', 'Paciente::guardar');


//-----------------------------------------------------------------------