<?php
declare(strict_types=1);

ini_set('display_errors', '0');
header('X-Content-Type-Options: nosniff');

require __DIR__ . '/../src/conexion.php';

$ruta = $_GET['ruta'] ?? '/peliculas';
if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '') {
    $ruta = null;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && is_string($ruta) && $ruta === '/salud') {
    header('Content-Type: text/plain; charset=UTF-8');
    try {
        conexion()->query('SELECT 1');
        http_response_code(200);
        echo "OK\n";
    } catch (Throwable $error) {
        error_log('Fallo en comprobación de salud: ' . $error->getMessage());
        http_response_code(503);
        echo "NO DISPONIBLE\n";
    }
    return;
}

ini_set('session.use_strict_mode', '1');
session_start(['cookie_httponly' => true, 'cookie_samesite' => 'Lax',
    'cookie_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off']);
$_SESSION['csrf'] ??= bin2hex(random_bytes(32));
header('Content-Type: text/html; charset=UTF-8');

require __DIR__ . '/../src/validacion.php';
require __DIR__ . '/../src/peliculas.php';
require __DIR__ . '/../src/presentacion.php';
require __DIR__ . '/../src/rutas.php';

try {
    atenderPeticion($ruta);
} catch (Throwable $error) {
    error_log('Error en la aplicación de películas: ' . $error->getMessage());
    mostrar('error', ['titulo' => 'Servicio no disponible', 'mensaje' => 'No se ha podido completar la operación. Inténtalo de nuevo más tarde.'], 500);
}
