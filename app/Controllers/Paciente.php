<?php
namespace App\Controllers;
use App\Models\PacienteModel;

class Paciente extends BaseController
{
    public function index()
    {
        // seinstancia el modelo
        $modelo = new PacienteModel();
        
        // se guardan todos 
        $datos['pacientes'] = $modelo->findAll();
        
        // retornamos una vista (lo hago desp) con los datos
        return view('pacientes/index', $datos);
    }
}
