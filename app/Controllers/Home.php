<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('templates/header', ['titulo' => 'Inicio'])
            . view('home')
            . view('templates/footer');
    }
}
