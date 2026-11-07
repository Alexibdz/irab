<?php

function nombre_completo(array $persona): string
{
    return trim(($persona['nombre'] ?? '') . ' ' . ($persona['apellido'] ?? ''));
}
