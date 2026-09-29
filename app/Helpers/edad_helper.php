<?php

/**
 * Edad del paciente en anios y meses.
 *
 * $hasta permite calcularla a una fecha distinta de hoy, por ejemplo la de
 * ingreso de la visita, que es la que define la escala y los cortes de FR.
 */
function edad_texto(?string $nacimiento, ?string $hasta = null): string
{
    if (empty($nacimiento)) {
        return 's/d';
    }

    $desde = new DateTime($nacimiento);
    $corte = new DateTime($hasta ?: 'today');

    if ($corte < $desde) {
        return 's/d';
    }

    $d = $desde->diff($corte);

    $partes = [];
    if ($d->y > 0) {
        $partes[] = $d->y . ($d->y === 1 ? ' año' : ' años');
    }
    if ($d->m > 0) {
        $partes[] = $d->m . ($d->m === 1 ? ' mes' : ' meses');
    }

    if (empty($partes)) {
        return $d->d . ($d->d === 1 ? ' día' : ' días');
    }

    return implode(' ', $partes);
}
