<?php

namespace App\Controllers;

class Home extends BaseController
{
    // La raiz y el panel son la misma pantalla
    public function index()
    {
        return redirect()->to(base_url('panel'));
    }
}
