<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Carga los datos mínimos para poder loguearse por primera vez:
     * un rol, un establecimiento y un usuario admin. Sin esto no se
     * puede crear nada desde la UI porque esas rutas están detrás del
     * filtro de autenticación (huevo y gallina).
     */
    public function run(): void
    {
        $rol = $this->db->table('roles')->where('nombre', 'Administrador')->get()->getRow();
        if (! $rol) {
            $this->db->table('roles')->insert(['nombre' => 'Administrador']);
            $idRol = $this->db->insertID();
        } else {
            $idRol = $rol->id;
        }

        $establecimiento = $this->db->table('establecimientos_salud')->where('nombre', 'Establecimiento Central')->get()->getRow();
        if (! $establecimiento) {
            $this->db->table('establecimientos_salud')->insert([
                'nombre' => 'Establecimiento Central',
                'cuartel' => null,
                'tipo' => 'Hospital',
            ]);
            $idEstablecimiento = $this->db->insertID();
        } else {
            $idEstablecimiento = $establecimiento->id;
        }

        $usuario = $this->db->table('usuarios')->where('username', 'admin')->get()->getRow();
        if (! $usuario) {
            $this->db->table('usuarios')->insert([
                'nombre' => 'Administrador',
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'id_rol' => $idRol,
                'id_establecimiento_asignado' => $idEstablecimiento,
            ]);
            echo "Usuario admin creado -> username: admin / password: admin123\n";
        } else {
            echo "El usuario admin ya existia, no se toco.\n";
        }
    }
}
