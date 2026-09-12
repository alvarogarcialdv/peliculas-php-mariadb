<?php
declare(strict_types=1);

function validarPelicula(array $entrada): array
{
    $datos = [];
    $errores = [];
    foreach (['titulo' => 200, 'director' => 120, 'genero' => 80, 'sinopsis' => 2000] as $campo => $limite) {
        $valor = $entrada[$campo] ?? '';
        $datos[$campo] = is_string($valor) ? trim($valor) : '';
        if (!is_string($valor) || !mb_check_encoding($datos[$campo], 'UTF-8')) {
            $errores[$campo] = 'Introduce un texto válido.';
        } elseif ($campo !== 'sinopsis' && $datos[$campo] === '') {
            $errores[$campo] = 'Este campo es obligatorio.';
        } elseif (mb_strlen($datos[$campo], 'UTF-8') > $limite) {
            $errores[$campo] = "No puede superar $limite caracteres.";
        }
    }
    $datos['anio'] = is_string($entrada['anio'] ?? null) ? trim($entrada['anio']) : '';
    $maximo = (int) date('Y') + 1;
    if (!preg_match('/^[0-9]{4}$/D', $datos['anio']) || (int) $datos['anio'] < 1888 || (int) $datos['anio'] > $maximo) {
        $errores['anio'] = "Introduce un año entero entre 1888 y $maximo.";
    }
    return [$datos, $errores];
}
