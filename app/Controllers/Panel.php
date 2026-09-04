<?php

namespace App\Controllers;

class Panel extends BaseController
{
    public function index()
    {
        echo view('templates/header');
        echo view('panel/inicio');
        echo view('templates/footer');
    }
}
