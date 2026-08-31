<?php

namespace App\Controllers;

class Panel extends BaseController
{
    public function index()
    {
        echo view('header');
        echo view('panel/inicio');
        echo view('footer');
    }
}
