<?php
declare(strict_types=1);

// El entorno se configura en el servidor; PHP no carga archivos .env automáticamente.
function configuracion(): array
{
    $valores = [];
    foreach (['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'] as $nombre) {
        $valor = getenv($nombre);
        if ($valor === false || ($valor === '' && $nombre !== 'DB_PASSWORD')) {
            throw new RuntimeException("Falta configurar $nombre.");
        }
        $valores[$nombre] = $valor;
    }
    if (!ctype_digit($valores['DB_PORT']) || (int) $valores['DB_PORT'] < 1 || (int) $valores['DB_PORT'] > 65535) {
        throw new RuntimeException('Puerto de base de datos inválido.');
    }
    foreach (['DB_HOST', 'DB_NAME'] as $nombre) {
        if (preg_match('/[;\x00-\x20]/', $valores[$nombre])) {
            throw new RuntimeException('Configuración de base de datos inválida.');
        }
    }
    return $valores;
}
