<?php

namespace App\Controllers;

class Configuracion extends BaseController
{
    // Hub de configuracion: accesos a cada modulo
    public function index()
    {
        echo view('templates/header', ['titulo' => 'Configuración']);
        echo view('configuracion/index');
        echo view('templates/footer');
    }
}
