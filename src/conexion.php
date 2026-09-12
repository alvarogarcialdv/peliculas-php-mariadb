<?php
declare(strict_types=1);

require_once __DIR__ . '/../configuracion/entorno.php';

function conexion(): PDO
{
    $configuracion = configuracion();
    return new PDO(
        'mysql:host=' . $configuracion['DB_HOST'] . ';port=' . $configuracion['DB_PORT']
        . ';dbname=' . $configuracion['DB_NAME'] . ';charset=utf8mb4',
        $configuracion['DB_USER'],
        $configuracion['DB_PASSWORD'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false]
    );
}
