<?php
//Controlador copia de seguridad hecho con inteligencia artifical.
namespace App\Controllers;

class CopiaSeguridad extends BaseController
{
    // Descarga la base completa como .sql
    public function exportar()
    {
        if (! puede('copia-seguridad', 'ver')) {
            return redirect()->to(base_url('panel'))
                ->with('error', 'No tenés permiso para exportar la base de datos.');
        }

        $nombre = 'irab_' . date('Y-m-d_His') . '.sql';

        return $this->response->download($nombre, $this->volcado());
    }

    // Tablas reales de la base, sin vistas
    private function tablas(): array
    {
        $filas = db_connect()->query("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'")->getResultArray();

        return array_map(fn ($fila) => reset($fila), $filas);
    }

    // Volcado completo: estructura y datos de cada tabla
    private function volcado(): string
    {
        $db = db_connect();

        $salida = [
            '-- IRAB: copia de seguridad',
            '-- Base: ' . $db->getDatabase(),
            '-- Fecha: ' . date('Y-m-d H:i:s'),
            '',
            'SET NAMES utf8mb4;',
            'SET FOREIGN_KEY_CHECKS = 0;',
            "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';",
        ];

        foreach ($this->tablas() as $tabla) {
            $nombre = $db->escapeIdentifiers($tabla);
            $estructura = $db->query('SHOW CREATE TABLE ' . $nombre)->getRowArray();

            $salida[] = '';
            $salida[] = '-- ' . $tabla;
            $salida[] = 'DROP TABLE IF EXISTS ' . $nombre . ';';
            $salida[] = $estructura['Create Table'] . ';';

            $filas = $db->query('SELECT * FROM ' . $nombre)->getResultArray();
            if (empty($filas)) {
                continue;
            }

            $columnas = implode(', ', array_map([$db, 'escapeIdentifiers'], array_keys($filas[0])));
            foreach (array_chunk($filas, 100) as $lote) {
                $valores = array_map(fn ($fila) => '(' . implode(', ', array_map([$db, 'escape'], $fila)) . ')', $lote);
                $salida[] = "INSERT INTO {$nombre} ({$columnas}) VALUES\n" . implode(",\n", $valores) . ';';
            }
        }

        $salida[] = '';
        $salida[] = 'SET FOREIGN_KEY_CHECKS = 1;';

        return implode("\n", $salida) . "\n";
    }
}
