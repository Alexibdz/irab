<?php

namespace App\Controllers;

use App\Models\MedicacionModel;

class Medicaciones extends BaseController
{
    protected MedicacionModel $medicacionModel;

    public function __construct()
    {
        $this->medicacionModel = new MedicacionModel();
        helper('form');
    }

    public function index()
    {
        $datos = [
            'titulo' => 'Medicaciones',
            'medicaciones' => $this->medicacionModel->orderBy('nombre')->findAll(),
        ];

        echo view('templates/header', $datos);
        echo view('medicaciones/listado', $datos);
        echo view('templates/footer');
    }

    public function nuevo()
    {
        $datos = ['titulo' => 'Nueva medicación'];

        echo view('templates/header', $datos);
        echo view('medicaciones/formulario', $datos);
        echo view('templates/footer');
    }

    public function insertar()
    {
        if (!$this->validate([
            'nombre' => 'required|min_length[2]|max_length[100]|is_unique[medicaciones.nombre]',
        ], [
            'nombre' => [
                'required' => 'El nombre de la medicación es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 2 caracteres.',
                'is_unique' => 'Ya existe una medicación con ese nombre.',
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->medicacionModel->insert([
            'nombre' => trim((string) $this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('configuracion/medicaciones'))
            ->with('exito', 'Medicación creada correctamente.');
    }

    public function editar($id)
    {
        $medicacion = $this->medicacionModel->find($id);
        if (!$medicacion) {
            return redirect()->to(base_url('configuracion/medicaciones'))
                ->with('error', 'La medicación no existe.');
        }

        $datos = ['titulo' => 'Editar medicación', 'medicacion' => $medicacion];

        echo view('templates/header', $datos);
        echo view('medicaciones/formulario', $datos);
        echo view('templates/footer');
    }

    public function actualizar()
    {
        $id = (int) $this->request->getPost('id');
        $medicacion = $this->medicacionModel->find($id);
        if (!$medicacion) {
            return redirect()->to(base_url('configuracion/medicaciones'))
                ->with('error', 'La medicación no existe.');
        }

        if (!$this->validate([
            'nombre' => "required|min_length[2]|max_length[100]|is_unique[medicaciones.nombre,id,{$id}]",
        ], [
            'nombre' => [
                'required' => 'El nombre de la medicación es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 2 caracteres.',
                'is_unique' => 'Ya existe una medicación con ese nombre.',
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->medicacionModel->update($id, [
            'nombre' => trim((string) $this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('configuracion/medicaciones'))
            ->with('exito', 'Medicación actualizada correctamente.');
    }

    public function eliminar($id)
    {
        if (!$this->medicacionModel->find($id)) {
            return redirect()->to(base_url('configuracion/medicaciones'))
                ->with('error', 'La medicación no existe.');
        }

        $this->medicacionModel->delete($id);

        return redirect()->to(base_url('configuracion/medicaciones'))
            ->with('exito', 'Medicación eliminada correctamente.');
    }

    public function eliminados()
    {
        $datos = [
            'titulo' => 'Medicaciones eliminadas',
            'medicaciones' => $this->medicacionModel->onlyDeleted()->orderBy('nombre')->findAll(),
        ];

        echo view('templates/header', $datos);
        echo view('medicaciones/eliminados', $datos);
        echo view('templates/footer');
    }

    public function recuperar($id)
    {
        if (!$this->medicacionModel->onlyDeleted()->find($id)) {
            return redirect()->to(base_url('configuracion/medicaciones/eliminados'))
                ->with('error', 'La medicación eliminada no existe.');
        }

        $this->medicacionModel->update($id, ['fecha_borrado' => null]);

        return redirect()->to(base_url('configuracion/medicaciones'))
            ->with('exito', 'Medicación recuperada correctamente.');
    }
}
